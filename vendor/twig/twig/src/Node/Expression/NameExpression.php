<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: NameExpression.php
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
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\Node\Expression;

use Twig\Compiler;
use const PHP_VERSION_ID;

class NameExpression extends AbstractExpression
{

	private $specialVars = [
		'_self'    => '$this->getTemplateName()',
		'_context' => '$context',
		'_charset' => '$this->env->getCharset()',
	];

	public function __construct(string $name, int $lineno)
	{

		parent::__construct([], ['name' => $name, 'is_defined_test' => false, 'ignore_strict_check' => false, 'always_defined' => false], $lineno);
	}

	public function compile(Compiler $compiler): void
	{

		$name = $this->getAttribute('name');

		$compiler->addDebugInfo($this);

		if ($this->getAttribute('is_defined_test')) {
			if ($this->isSpecial()) {
				$compiler->repr(true);
			} elseif (PHP_VERSION_ID >= 70400) {
				$compiler
					->raw('array_key_exists(')
					->string($name)
					->raw(', $context)');
			} else {
				$compiler
					->raw('(isset($context[')
					->string($name)
					->raw(']) || array_key_exists(')
					->string($name)
					->raw(', $context))');
			}
		} elseif ($this->isSpecial()) {
			$compiler->raw($this->specialVars[$name]);
		} elseif ($this->getAttribute('always_defined')) {
			$compiler
				->raw('$context[')
				->string($name)
				->raw(']');
		} else {
			if ($this->getAttribute('ignore_strict_check') || !$compiler->getEnvironment()->isStrictVariables()) {
				$compiler
					->raw('($context[')
					->string($name)
					->raw('] ?? null)');
			} else {
				$compiler
					->raw('(isset($context[')
					->string($name)
					->raw(']) || array_key_exists(')
					->string($name)
					->raw(', $context) ? $context[')
					->string($name)
					->raw('] : (function () { throw new RuntimeError(\'Variable ')
					->string($name)
					->raw(' does not exist.\', ')
					->repr($this->lineno)
					->raw(', $this->source); })()')
					->raw(')');
			}
		}
	}

	public function isSpecial()
	{

		return isset($this->specialVars[$this->getAttribute('name')]);
	}

	public function isSimple()
	{

		return !$this->isSpecial() && !$this->getAttribute('is_defined_test');
	}

}
