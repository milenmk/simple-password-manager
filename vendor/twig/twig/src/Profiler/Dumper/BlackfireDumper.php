<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: BlackfireDumper.php
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

namespace Twig\Profiler\Dumper;

use Twig\Profiler\Profile;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class BlackfireDumper
{

	public function dump(Profile $profile): string
	{

		$data = [];
		$this->dumpProfile('main()', $profile, $data);
		$this->dumpChildren('main()', $profile, $data);

		$start = sprintf('%f', microtime(true));
		$str = <<<EOF
file-format: BlackfireProbe
cost-dimensions: wt mu pmu
request-start: $start


EOF;

		foreach ($data as $name => $values) {
			$str .= "$name//{$values['ct']} {$values['wt']} {$values['mu']} {$values['pmu']}\n";
		}

		return $str;
	}

	private function dumpProfile(string $edge, Profile $profile, &$data)
	{

		if (isset($data[$edge])) {
			++$data[$edge]['ct'];
			$data[$edge]['wt'] += floor($profile->getDuration() * 1000000);
			$data[$edge]['mu'] += $profile->getMemoryUsage();
			$data[$edge]['pmu'] += $profile->getPeakMemoryUsage();
		} else {
			$data[$edge] = [
				'ct'  => 1,
				'wt'  => floor($profile->getDuration() * 1000000),
				'mu'  => $profile->getMemoryUsage(),
				'pmu' => $profile->getPeakMemoryUsage(),
			];
		}
	}

	private function dumpChildren(string $parent, Profile $profile, &$data)
	{

		foreach ($profile as $p) {
			if ($p->isTemplate()) {
				$name = $p->getTemplate();
			} else {
				$name = sprintf('%s::%s(%s)', $p->getTemplate(), $p->getType(), $p->getName());
			}
			$this->dumpProfile(sprintf('%s==>%s', $parent, $name), $p, $data);
			$this->dumpChildren($name, $p, $data);
		}
	}

}
