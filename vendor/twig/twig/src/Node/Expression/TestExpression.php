<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: TestExpression.php
 *  Last Modified: 30.12.22 г., 5:53 ч.
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

namespace Twig\Node\Expression;

use Twig\Compiler;
use Twig\Node\Node;

class TestExpression extends CallExpression
{

	public function __construct(Node $node, string $name, ?Node $arguments, int $lineno)
	{

		$nodes = ['node' => $node];
		if (null !== $arguments) {
			$nodes['arguments'] = $arguments;
		}

		parent::__construct($nodes, ['name' => $name], $lineno);
	}

	public function compile(Compiler $compiler): void
	{

		$name = $this->getAttribute('name');
		$test = $compiler->getEnvironment()->getTest($name);

		$this->setAttribute('name', $name);
		$this->setAttribute('type', 'test');
		$this->setAttribute('arguments', $test->getArguments());
		$this->setAttribute('callable', $test->getCallable());
		$this->setAttribute('is_variadic', $test->isVariadic());

		$this->compileCallable($compiler);
	}

}
