<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: MacroTokenParser.php
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
use Twig\Node\BodyNode;
use Twig\Node\MacroNode;
use Twig\Node\Node;
use Twig\Token;

/**
 * Defines a macro.
 *
 *   {% macro input(name, value, type, size) %}
 *      <input type="{{ type|default('text') }}" name="{{ name }}" value="{{ value|e }}" size="{{ size|default(20) }}" />
 *   {% endmacro %}
 *
 * @internal
 */
final class MacroTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$lineno = $token->getLine();
		$stream = $this->parser->getStream();
		$name = $stream->expect(/* Token::NAME_TYPE */ 5)->getValue();

		$arguments = $this->parser->getExpressionParser()->parseArguments(true, true);

		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);
		$this->parser->pushLocalScope();
		$body = $this->parser->subparse([$this, 'decideBlockEnd'], true);
		if ($token = $stream->nextIf(/* Token::NAME_TYPE */ 5)) {
			$value = $token->getValue();

			if ($value != $name) {
				throw new SyntaxError(sprintf('Expected endmacro for macro "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
			}
		}
		$this->parser->popLocalScope();
		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		$this->parser->setMacro($name, new MacroNode($name, new BodyNode([$body]), $arguments, $lineno, $this->getTag()));

		return new Node();
	}

	public function getTag(): string
	{

		return 'macro';
	}

	public function decideBlockEnd(Token $token): bool
	{

		return $token->test('endmacro');
	}

}
