<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SetTokenParser.php
 *  Last Modified: 31.12.22 г., 22:13 ч.
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
use Twig\Node\Node;
use Twig\Node\SetNode;
use Twig\Token;
use function count;

/**
 * Defines a variable.
 *
 *  {% set foo = 'foo' %}
 *  {% set foo = [1, 2] %}
 *  {% set foo = {'foo': 'bar'} %}
 *  {% set foo = 'foo' ~ 'bar' %}
 *  {% set foo, bar = 'foo', 'bar' %}
 *  {% set foo %}Some content{% endset %}
 *
 * @internal
 */
final class SetTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$lineno = $token->getLine();
		$stream = $this->parser->getStream();
		$names = $this->parser->getExpressionParser()->parseAssignmentExpression();

		$capture = false;
		if ($stream->nextIf(/* Token::OPERATOR_TYPE */ 8, '=')) {
			$values = $this->parser->getExpressionParser()->parseMultitargetExpression();

			$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

			if (count($names) !== count($values)) {
				throw new SyntaxError('When using set, you must have the same number of variables and assignments.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
			}
		} else {
			$capture = true;

			if (count($names) > 1) {
				throw new SyntaxError('When using set with a block, you cannot have a multi-target.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
			}

			$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

			$values = $this->parser->subparse([$this, 'decideBlockEnd'], true);
			$stream->expect(/* Token::BLOCK_END_TYPE */ 3);
		}

		return new SetNode($capture, $names, $values, $lineno, $this->getTag());
	}

	public function getTag(): string
	{

		return 'set';
	}

	public function decideBlockEnd(Token $token): bool
	{

		return $token->test('endset');
	}

}
