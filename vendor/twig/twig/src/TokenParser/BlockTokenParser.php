<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: BlockTokenParser.php
 *  Last Modified: 31.12.22 г., 22:11 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.2.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\TokenParser;

use Twig\Error\SyntaxError;
use Twig\Node\BlockNode;
use Twig\Node\BlockReferenceNode;
use Twig\Node\Node;
use Twig\Node\PrintNode;
use Twig\Token;

/**
 * Marks a section of a template as being reusable.
 *
 *  {% block head %}
 *    <link rel="stylesheet" href="style.css" />
 *    <title>{% block title %}{% endblock %} - My Webpage</title>
 *  {% endblock %}
 *
 * @internal
 */
final class BlockTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$lineno = $token->getLine();
		$stream = $this->parser->getStream();
		$name = $stream->expect(/* Token::NAME_TYPE */ 5)->getValue();
		if ($this->parser->hasBlock($name)) {
			throw new SyntaxError(sprintf("The block '%s' has already been defined line %d.", $name, $this->parser->getBlock($name)->getTemplateLine()), $stream->getCurrent()->getLine(), $stream->getSourceContext());
		}
		$this->parser->setBlock($name, $block = new BlockNode($name, new Node([]), $lineno));
		$this->parser->pushLocalScope();
		$this->parser->pushBlockStack($name);

		if ($stream->nextIf(/* Token::BLOCK_END_TYPE */ 3)) {
			$body = $this->parser->subparse([$this, 'decideBlockEnd'], true);
			if ($token = $stream->nextIf(/* Token::NAME_TYPE */ 5)) {
				$value = $token->getValue();

				if ($value != $name) {
					throw new SyntaxError(sprintf('Expected endblock for block "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
				}
			}
		} else {
			$body = new Node(
				[
					new PrintNode($this->parser->getExpressionParser()->parseExpression(), $lineno),
				]
			);
		}
		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		$block->setNode('body', $body);
		$this->parser->popBlockStack();
		$this->parser->popLocalScope();

		return new BlockReferenceNode($name, $lineno, $this->getTag());
	}

	public function getTag(): string
	{

		return 'block';
	}

	public function decideBlockEnd(Token $token): bool
	{

		return $token->test('endblock');
	}

}
