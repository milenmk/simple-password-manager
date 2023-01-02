<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: CacheInterface.php
 *  Last Modified: 31.12.22 г., 22:09 ч.
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

namespace Twig\Cache;

/**
 * Interface implemented by cache classes.
 *
 * It is highly recommended to always store templates on the filesystem to
 * benefit from the PHP opcode cache. This interface is mostly useful if you
 * need to implement a custom strategy for storing templates on the filesystem.
 *
 * @author Andrew Tch <andrew@noop.lv>
 */
interface CacheInterface
{

	/**
	 * Generates a cache key for the given template class name.
	 */
	public function generateKey(string $name, string $className): string;

	/**
	 * Writes the compiled template to cache.
	 *
	 * @param string $content The template representation as a PHP class
	 */
	public function write(string $key, string $content): void;

	/**
	 * Loads a template from the cache.
	 */
	public function load(string $key): void;

	/**
	 * Returns the modification timestamp of a key.
	 */
	public function getTimestamp(string $key): int;

}
