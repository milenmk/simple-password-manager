<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: TokenParserInterface.php
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

use Twig\Error\SyntaxError;
use Twig\Node\Node;
use Twig\Parser;
use Twig\Token;

/**
 * Interface implemented by token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface TokenParserInterface
{

	/**
	 * Sets the parser associated with this token parser.
	 */
	public function setParser(Parser $parser): void;

	/**
	 * Parses a token and returns a node.
	 *
	 * @return Node
	 *
	 * @throws SyntaxError
	 */
	public function parse(Token $token);

	/**
	 * Gets the tag name associated with this token parser.
	 *
	 * @return string
	 */
	public function getTag();

}
