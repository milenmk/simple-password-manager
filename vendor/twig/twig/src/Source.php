<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Source.php
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

namespace Twig;

/**
 * Holds information about a non-compiled Twig template.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class Source
{

	private $code;
	private $name;
	private $path;

	/**
	 * @param string $code The template source code
	 * @param string $name The template logical name
	 * @param string $path The filesystem path of the template if any
	 */
	public function __construct(string $code, string $name, string $path = '')
	{

		$this->code = $code;
		$this->name = $name;
		$this->path = $path;
	}

	public function getCode(): string
	{

		return $this->code;
	}

	public function getName(): string
	{

		return $this->name;
	}

	public function getPath(): string
	{

		return $this->path;
	}

}
