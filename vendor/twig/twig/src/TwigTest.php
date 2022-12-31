<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: TwigTest.php
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

use Twig\Node\Expression\TestExpression;
use function is_bool;

/**
 * Represents a template test.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @see    https://twig.symfony.com/doc/templates.html#test-operator
 */
final class TwigTest
{

	private $name;
	private $callable;
	private $options;
	private $arguments = [];

	/**
	 * @param callable|null $callable A callable implementing the test. If null, you need to overwrite the "node_class" option to customize compilation.
	 */
	public function __construct(string $name, $callable = null, array $options = [])
	{

		$this->name = $name;
		$this->callable = $callable;
		$this->options = array_merge(
																																									 [
																																									  'is_variadic'            => false,
																																									  'node_class'  => TestExpression::class,
																																									  'deprecated'  => false,
																																									  'alternative' => null,
																																									  'one_mandatory_argument' => false,
																																								  ], $options
		);
	}

	public function getName(): string
	{

		return $this->name;
	}

	/**
	 * Returns the callable to execute for this test.
	 *
	 * @return callable|null
	 */
	public function getCallable()
	{

		return $this->callable;
	}

	public function getNodeClass(): string
	{

		return $this->options['node_class'];
	}

	public function getArguments(): array
	{

		return $this->arguments;
	}

	public function setArguments(array $arguments): void
	{

		$this->arguments = $arguments;
	}

	public function isVariadic(): bool
	{

		return (bool)$this->options['is_variadic'];
	}

	public function isDeprecated(): bool
	{

		return (bool)$this->options['deprecated'];
	}

	public function getDeprecatedVersion(): string
	{

		return is_bool($this->options['deprecated']) ? '' : $this->options['deprecated'];
	}

	public function getAlternative(): ?string
	{

		return $this->options['alternative'];
	}

	public function hasOneMandatoryArgument(): bool
	{

		return (bool)$this->options['one_mandatory_argument'];
	}

}
