<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: StringLoaderExtension.php
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

namespace Twig\Extension {

	use Twig\TwigFunction;

	final class StringLoaderExtension extends AbstractExtension
	{

		public function getFunctions(): array
		{

			return [
				new TwigFunction('template_from_string', 'twig_template_from_string', ['needs_environment' => true]),
			];
		}

	}
}

namespace {

	use Twig\Environment;
	use Twig\TemplateWrapper;

	/**
	 * Loads a template from a string.
	 *
	 *     {{ include(template_from_string("Hello {{ name }}")) }}
	 *
	 * @param string $template A template as a string or object implementing __toString()
	 * @param string $name     An optional name of the template to be used in error messages
	 */
	function twig_template_from_string(Environment $env, $template, string $name = null): TemplateWrapper
	{

		return $env->createTemplate((string)$template, $name);
	}
}
