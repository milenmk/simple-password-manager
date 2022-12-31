<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ConditionalExpression.php
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

class ConditionalExpression extends AbstractExpression
{

	public function __construct(AbstractExpression $expr1, AbstractExpression $expr2, AbstractExpression $expr3, int $lineno)
	{

		parent::__construct(['expr1' => $expr1, 'expr2' => $expr2, 'expr3' => $expr3], [], $lineno);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler
			->raw('((')
			->subcompile($this->getNode('expr1'))
			->raw(') ? (')
			->subcompile($this->getNode('expr2'))
			->raw(') : (')
			->subcompile($this->getNode('expr3'))
			->raw('))');
	}

}
