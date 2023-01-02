<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: StartsWithBinary.php
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

namespace Twig\Node\Expression\Binary;

use Twig\Compiler;

class StartsWithBinary extends AbstractBinary
{

	public function compile(Compiler $compiler): void
	{

		$left = $compiler->getVarName();
		$right = $compiler->getVarName();
		$compiler
			->raw(sprintf('(is_string($%s = ', $left))
			->subcompile($this->getNode('left'))
			->raw(sprintf(') && is_string($%s = ', $right))
			->subcompile($this->getNode('right'))
			->raw(sprintf(') && (\'\' === $%2$s || 0 === strpos($%1$s, $%2$s)))', $left, $right));
	}

	public function operator(Compiler $compiler): Compiler
	{

		return $compiler->raw('');
	}

}
