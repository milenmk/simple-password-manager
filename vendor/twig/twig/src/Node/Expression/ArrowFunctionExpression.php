<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ArrowFunctionExpression.php
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

/**
 * Represents an arrow function.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ArrowFunctionExpression extends AbstractExpression
{

	public function __construct(AbstractExpression $expr, Node $names, $lineno, $tag = null)
	{

		parent::__construct(['expr' => $expr, 'names' => $names], [], $lineno, $tag);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler
			->addDebugInfo($this)
			->raw('function (');
		foreach ($this->getNode('names') as $i => $name) {
			if ($i) {
				$compiler->raw(', ');
			}

			$compiler
				->raw('$__')
				->raw($name->getAttribute('name'))
				->raw('__');
		}
		$compiler
			->raw(') use ($context, $macros) { ');
		foreach ($this->getNode('names') as $name) {
			$compiler
				->raw('$context["')
				->raw($name->getAttribute('name'))
				->raw('"] = $__')
				->raw($name->getAttribute('name'))
				->raw('__; ');
		}
		$compiler
			->raw('return ')
			->subcompile($this->getNode('expr'))
			->raw('; }');
	}

}
