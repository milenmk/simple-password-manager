<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ExtendsTokenParser.php
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
use Twig\Node\Node;
use Twig\Token;

/**
 * Extends a template by another one.
 *
 *  {% extends "base.html" %}
 *
 * @internal
 */
final class ExtendsTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$stream = $this->parser->getStream();

		if ($this->parser->peekBlockStack()) {
			throw new SyntaxError('Cannot use "extend" in a block.', $token->getLine(), $stream->getSourceContext());
		} elseif (!$this->parser->isMainScope()) {
			throw new SyntaxError('Cannot use "extend" in a macro.', $token->getLine(), $stream->getSourceContext());
		}

		if (null !== $this->parser->getParent()) {
			throw new SyntaxError('Multiple extends tags are forbidden.', $token->getLine(), $stream->getSourceContext());
		}
		$this->parser->setParent($this->parser->getExpressionParser()->parseExpression());

		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		return new Node();
	}

	public function getTag(): string
	{

		return 'extends';
	}

}
