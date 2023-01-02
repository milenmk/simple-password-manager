<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: AutoEscapeTokenParser.php
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
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\TokenParser;

use Twig\Error\SyntaxError;
use Twig\Node\AutoEscapeNode;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\Token;

/**
 * Marks a section of a template to be escaped or not.
 *
 * @internal
 */
final class AutoEscapeTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$lineno = $token->getLine();
		$stream = $this->parser->getStream();

		if ($stream->test(/* Token::BLOCK_END_TYPE */ 3)) {
			$value = 'html';
		} else {
			$expr = $this->parser->getExpressionParser()->parseExpression();
			if (!$expr instanceof ConstantExpression) {
				throw new SyntaxError('An escaping strategy must be a string or false.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
			}
			$value = $expr->getAttribute('value');
		}

		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);
		$body = $this->parser->subparse([$this, 'decideBlockEnd'], true);
		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		return new AutoEscapeNode($value, $body, $lineno, $this->getTag());
	}

	public function getTag(): string
	{

		return 'autoescape';
	}

	public function decideBlockEnd(Token $token): bool
	{

		return $token->test('endautoescape');
	}

}
