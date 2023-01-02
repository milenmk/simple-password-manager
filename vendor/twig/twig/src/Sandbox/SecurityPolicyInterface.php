<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SecurityPolicyInterface.php
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

namespace Twig\Sandbox;

/**
 * Interface that all security policy classes must implements.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface SecurityPolicyInterface
{

	/**
	 * @param string[] $tags
	 * @param string[] $filters
	 * @param string[] $functions
	 *
	 * @throws SecurityError
	 */
	public function checkSecurity($tags, $filters, $functions): void;

	/**
	 * @param object $obj
	 * @param string $method
	 *
	 * @throws SecurityNotAllowedMethodError
	 */
	public function checkMethodAllowed($obj, $method): void;

	/**
	 * @param object $obj
	 * @param string $property
	 *
	 * @throws SecurityNotAllowedPropertyError
	 */
	public function checkPropertyAllowed($obj, $property): void;

}
