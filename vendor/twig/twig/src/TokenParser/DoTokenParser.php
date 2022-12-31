<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DoTokenParser.php
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
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\TokenParser;

use Twig\Node\DoNode;
use Twig\Node\Node;
use Twig\Token;

/**
 * Evaluates an expression, discarding the returned value.
 *
 * @internal
 */
final class DoTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$expr = $this->parser->getExpressionParser()->parseExpression();

		$this->parser->getStream()->expect(/* Token::BLOCK_END_TYPE */ 3);

		return new DoNode($expr, $token->getLine(), $this->getTag());
	}

	public function getTag(): string
	{

		return 'do';
	}

}
