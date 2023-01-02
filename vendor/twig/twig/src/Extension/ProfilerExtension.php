<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ProfilerExtension.php
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

namespace Twig\Extension;

use Twig\Profiler\NodeVisitor\ProfilerNodeVisitor;
use Twig\Profiler\Profile;
use function count;

class ProfilerExtension extends AbstractExtension
{

	private $actives = [];

	public function __construct(Profile $profile)
	{

		$this->actives[] = $profile;
	}

	/**
	 * @return void
	 */
	public function enter(Profile $profile)
	{

		$this->actives[0]->addProfile($profile);
		array_unshift($this->actives, $profile);
	}

	/**
	 * @return void
	 */
	public function leave(Profile $profile)
	{

		$profile->leave();
		array_shift($this->actives);

		if (1 === count($this->actives)) {
			$this->actives[0]->leave();
		}
	}

	public function getNodeVisitors(): array
	{

		return [new ProfilerNodeVisitor(static::class)];
	}

}
