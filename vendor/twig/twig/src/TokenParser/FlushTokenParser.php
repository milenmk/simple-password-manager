<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FlushTokenParser.php
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

use Twig\Node\FlushNode;
use Twig\Node\Node;
use Twig\Token;

/**
 * Flushes the output to the client.
 *
 * @see flush()
 *
 * @internal
 */
final class FlushTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$this->parser->getStream()->expect(/* Token::BLOCK_END_TYPE */ 3);

		return new FlushNode($token->getLine(), $this->getTag());
	}

	public function getTag(): string
	{

		return 'flush';
	}

}
