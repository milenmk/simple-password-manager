<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DeprecationCollector.php
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

namespace Twig\Util;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Traversable;
use Twig\Environment;
use Twig\Error\SyntaxError;
use Twig\Source;
use const E_USER_DEPRECATED;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class DeprecationCollector
{

	private $twig;

	public function __construct(Environment $twig)
	{

		$this->twig = $twig;
	}

	/**
	 * Returns deprecations for templates contained in a directory.
	 *
	 * @param string $dir A directory where templates are stored
	 * @param string $ext Limit the loaded templates by extension
	 *
	 * @return array An array of deprecations
	 */
	public function collectDir(string $dir, string $ext = '.twig'): array
	{

		$iterator = new RegexIterator(
			new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::LEAVES_ONLY
			), '{' . preg_quote($ext) . '$}'
		);

		return $this->collect(new TemplateDirIterator($iterator));
	}

	/**
	 * Returns deprecations for passed templates.
	 *
	 * @param Traversable $iterator An iterator of templates (where keys are template names and values the contents of the template)
	 *
	 * @return array An array of deprecations
	 */
	public function collect(Traversable $iterator): array
	{

		$deprecations = [];
		set_error_handler(
			function ($type, $msg) use (&$deprecations) {

				if (E_USER_DEPRECATED === $type) {
					$deprecations[] = $msg;
				}
			}
		);

		foreach ($iterator as $name => $contents) {
			try {
				$this->twig->parse($this->twig->tokenize(new Source($contents, $name)));
			}
			catch (SyntaxError $e) {
				// ignore templates containing syntax errors
			}
		}

		restore_error_handler();

		return $deprecations;
	}

}
