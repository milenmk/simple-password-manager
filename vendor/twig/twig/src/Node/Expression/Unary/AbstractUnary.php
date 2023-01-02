<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: AbstractUnary.php
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
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\Node\Expression\Unary;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

abstract class AbstractUnary extends AbstractExpression
{

	public function __construct(Node $node, int $lineno)
	{

		parent::__construct(['node' => $node], [], $lineno);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler->raw(' ');
		$this->operator($compiler);
		$compiler->subcompile($this->getNode('node'));
	}

	abstract public function operator(Compiler $compiler): Compiler;

}
