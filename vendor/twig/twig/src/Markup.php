<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Markup.php
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

namespace Twig;

use Countable;
use JsonSerializable;
use ReturnTypeWillChange;

/**
 * Marks a content as safe.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Markup implements Countable, JsonSerializable
{

	private $content;
	private $charset;

	public function __construct($content, $charset)
	{

		$this->content = (string)$content;
		$this->charset = $charset;
	}

	public function __toString()
	{

		return $this->content;
	}

	/**
	 * @return int
	 */
	#[ReturnTypeWillChange]
	public function count()
	{

		return mb_strlen($this->content, $this->charset);
	}

	/**
	 * @return mixed
	 */
	#[ReturnTypeWillChange]
	public function jsonSerialize()
	{

		return $this->content;
	}

}
