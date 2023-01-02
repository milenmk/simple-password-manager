<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DebugExtension.php
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

namespace Twig\Extension {

	use Twig\TwigFunction;
	use function extension_loaded;
	use const PHP_SAPI;

	final class DebugExtension extends AbstractExtension
	{

		public function getFunctions(): array
		{

			// dump is safe if var_dump is overridden by xdebug
			$isDumpOutputHtmlSafe = extension_loaded('xdebug')
									// false means that it was not set (and the default is on) or it explicitly enabled
									&& (false === ini_get('xdebug.overload_var_dump') || ini_get('xdebug.overload_var_dump'))
									// false means that it was not set (and the default is on) or it explicitly enabled
									// xdebug.overload_var_dump produces HTML only when html_errors is also enabled
									&& (false === ini_get('html_errors') || ini_get('html_errors'))
									|| 'cli' === PHP_SAPI;

			return [
				new TwigFunction('dump', 'twig_var_dump', ['is_safe' => $isDumpOutputHtmlSafe ? ['html'] : [], 'needs_context' => true, 'needs_environment' => true, 'is_variadic' => true]),
			];
		}

	}
}

namespace {

	use Twig\Environment;
	use Twig\Template;
	use Twig\TemplateWrapper;

	function twig_var_dump(Environment $env, $context, ...$vars)
	{

		if (!$env->isDebug()) {
			return;
		}

		ob_start();

		if (!$vars) {
			$vars = [];
			foreach ($context as $key => $value) {
				if (!$value instanceof Template && !$value instanceof TemplateWrapper) {
					$vars[$key] = $value;
				}
			}

			var_dump($vars);
		} else {
			var_dump(...$vars);
		}

		return ob_get_clean();
	}
}
