<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: LoaderInterface.php
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

namespace Twig\Loader;

use Twig\Error\LoaderError;
use Twig\Source;

/**
 * Interface all loaders must implement.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface LoaderInterface
{

	/**
	 * Returns the source context for a given template logical name.
	 *
	 * @throws LoaderError When $name is not found
	 */
	public function getSourceContext(string $name): Source;

	/**
	 * Gets the cache key to use for the cache for a given template name.
	 *
	 * @throws LoaderError When $name is not found
	 */
	public function getCacheKey(string $name): string;

	/**
	 * @param int $time Timestamp of the last modification time of the cached template
	 *
	 * @throws LoaderError When $name is not found
	 */
	public function isFresh(string $name, int $time): bool;

	/**
	 * @return bool
	 */
	public function exists(string $name);

}
