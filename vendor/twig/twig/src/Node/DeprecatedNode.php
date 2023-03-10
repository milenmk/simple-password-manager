<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DeprecatedNode.php
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

namespace Twig\Node;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Expression\ConstantExpression;

/**
 * Represents a deprecated node.
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class DeprecatedNode extends Node
{

	public function __construct(AbstractExpression $expr, int $lineno, string $tag = null)
	{

		parent::__construct(['expr' => $expr], [], $lineno, $tag);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler->addDebugInfo($this);

		$expr = $this->getNode('expr');

		if ($expr instanceof ConstantExpression) {
			$compiler->write('@trigger_error(')
				->subcompile($expr);
		} else {
			$varName = $compiler->getVarName();
			$compiler->write(sprintf('$%s = ', $varName))
				->subcompile($expr)
				->raw(";\n")
				->write(sprintf('@trigger_error($%s', $varName));
		}

		$compiler
			->raw('.')
			->string(sprintf(' ("%s" at line %d).', $this->getTemplateName(), $this->getTemplateLine()))
			->raw(", E_USER_DEPRECATED);\n");
	}

}
