<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: MethodCallExpression.php
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

class MethodCallExpression extends AbstractExpression
{

	public function __construct(AbstractExpression $node, string $method, ArrayExpression $arguments, int $lineno)
	{

		parent::__construct(['node' => $node, 'arguments' => $arguments], ['method' => $method, 'safe' => false, 'is_defined_test' => false], $lineno);

		if ($node instanceof NameExpression) {
			$node->setAttribute('always_defined', true);
		}
	}

	public function compile(Compiler $compiler): void
	{

		if ($this->getAttribute('is_defined_test')) {
			$compiler
				->raw('method_exists($macros[')
				->repr($this->getNode('node')->getAttribute('name'))
				->raw('], ')
				->repr($this->getAttribute('method'))
				->raw(')');

			return;
		}

		$compiler
			->raw('twig_call_macro($macros[')
			->repr($this->getNode('node')->getAttribute('name'))
			->raw('], ')
			->repr($this->getAttribute('method'))
			->raw(', [');
		$first = true;
		foreach ($this->getNode('arguments')->getKeyValuePairs() as $pair) {
			if (!$first) {
				$compiler->raw(', ');
			}
			$first = false;

			$compiler->subcompile($pair['value']);
		}
		$compiler
			->raw('], ')
			->repr($this->getTemplateLine())
			->raw(', $context, $this->getSourceContext())');
	}

}
