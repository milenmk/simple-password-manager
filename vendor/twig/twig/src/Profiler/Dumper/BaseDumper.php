<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: BaseDumper.php
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

namespace Twig\Profiler\Dumper;

use Twig\Profiler\Profile;
use function count;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class BaseDumper
{

	private $root;

	public function dump(Profile $profile): string
	{

		return $this->dumpProfile($profile);
	}

	private function dumpProfile(Profile $profile, $prefix = '', $sibling = false): string
	{

		if ($profile->isRoot()) {
			$this->root = $profile->getDuration();
			$start = $profile->getName();
		} else {
			if ($profile->isTemplate()) {
				$start = $this->formatTemplate($profile, $prefix);
			} else {
				$start = $this->formatNonTemplate($profile, $prefix);
			}
			$prefix .= $sibling ? '│ ' : '  ';
		}

		$percent = $this->root ? $profile->getDuration() / $this->root * 100 : 0;

		if ($profile->getDuration() * 1000 < 1) {
			$str = $start . "\n";
		} else {
			$str = sprintf("%s %s\n", $start, $this->formatTime($profile, $percent));
		}

		$nCount = count($profile->getProfiles());
		foreach ($profile as $i => $p) {
			$str .= $this->dumpProfile($p, $prefix, $i + 1 !== $nCount);
		}

		return $str;
	}

	abstract protected function formatTemplate(Profile $profile, $prefix): string;

	abstract protected function formatNonTemplate(Profile $profile, $prefix): string;

	abstract protected function formatTime(Profile $profile, $percent): string;

}
