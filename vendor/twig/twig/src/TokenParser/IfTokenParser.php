<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: IfTokenParser.php
 *  Last Modified: 30.12.22 г., 5:54 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.1.0
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
use Twig\Node\IfNode;
use Twig\Node\Node;
use Twig\Token;

/**
 * Tests a condition.
 *
 *   {% if users %}
 *    <ul>
 *      {% for user in users %}
 *        <li>{{ user.username|e }}</li>
 *      {% endfor %}
 *    </ul>
 *   {% endif %}
 *
 * @internal
 */
final class IfTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$lineno = $token->getLine();
		$expr = $this->parser->getExpressionParser()->parseExpression();
		$stream = $this->parser->getStream();
		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);
		$body = $this->parser->subparse([$this, 'decideIfFork']);
		$tests = [$expr, $body];
		$else = null;

		$end = false;
		while (!$end) {
			switch ($stream->next()->getValue()) {
				case 'else':
					$stream->expect(/* Token::BLOCK_END_TYPE */ 3);
					$else = $this->parser->subparse([$this, 'decideIfEnd']);
					break;

				case 'elseif':
					$expr = $this->parser->getExpressionParser()->parseExpression();
					$stream->expect(/* Token::BLOCK_END_TYPE */ 3);
					$body = $this->parser->subparse([$this, 'decideIfFork']);
					$tests[] = $expr;
					$tests[] = $body;
					break;

				case 'endif':
					$end = true;
					break;

				default:
					throw new SyntaxError(sprintf('Unexpected end of template. Twig was looking for the following tags "else", "elseif", or "endif" to close the "if" block started at line %d).', $lineno), $stream->getCurrent()->getLine(), $stream->getSourceContext());
			}
		}

		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		return new IfNode(new Node($tests), $else, $lineno, $this->getTag());
	}

	public function getTag(): string
	{

		return 'if';
	}

	public function decideIfFork(Token $token): bool
	{

		return $token->test(['elseif', 'else', 'endif']);
	}

	public function decideIfEnd(Token $token): bool
	{

		return $token->test(['endif']);
	}

}
