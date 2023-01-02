<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ParentExpression.php
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

namespace Twig\Node\Expression;

use Twig\Compiler;

/**
 * Represents a parent node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ParentExpression extends AbstractExpression
{

	public function __construct(string $name, int $lineno, string $tag = null)
	{

		parent::__construct([], ['output' => false, 'name' => $name], $lineno, $tag);
	}

	public function compile(Compiler $compiler): void
	{

		if ($this->getAttribute('output')) {
			$compiler
				->addDebugInfo($this)
				->write('$this->displayParentBlock(')
				->string($this->getAttribute('name'))
				->raw(", \$context, \$blocks);\n");
		} else {
			$compiler
				->raw('$this->renderParentBlock(')
				->string($this->getAttribute('name'))
				->raw(', $context, $blocks)');
		}
	}

}
