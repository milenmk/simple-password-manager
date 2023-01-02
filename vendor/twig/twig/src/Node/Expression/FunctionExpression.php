<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FunctionExpression.php
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

namespace Twig\Node\Expression;

use Twig\Compiler;
use Twig\Node\Node;

class FunctionExpression extends CallExpression
{

	public function __construct(string $name, Node $arguments, int $lineno)
	{

		parent::__construct(['arguments' => $arguments], ['name' => $name, 'is_defined_test' => false], $lineno);
	}

	public function compile(Compiler $compiler)
	{

		$name = $this->getAttribute('name');
		$function = $compiler->getEnvironment()->getFunction($name);

		$this->setAttribute('name', $name);
		$this->setAttribute('type', 'function');
		$this->setAttribute('needs_environment', $function->needsEnvironment());
		$this->setAttribute('needs_context', $function->needsContext());
		$this->setAttribute('arguments', $function->getArguments());
		$callable = $function->getCallable();
		if ('constant' === $name && $this->getAttribute('is_defined_test')) {
			$callable = 'twig_constant_is_defined';
		}
		$this->setAttribute('callable', $callable);
		$this->setAttribute('is_variadic', $function->isVariadic());

		$this->compileCallable($compiler);
	}

}
