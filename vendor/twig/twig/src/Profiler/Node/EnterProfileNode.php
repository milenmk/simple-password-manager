<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: EnterProfileNode.php
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

namespace Twig\Profiler\Node;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * Represents a profile enter node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class EnterProfileNode extends Node
{

	public function __construct(string $extensionName, string $type, string $name, string $varName)
	{

		parent::__construct([], ['extension_name' => $extensionName, 'name' => $name, 'type' => $type, 'var_name' => $varName]);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler
			->write(sprintf('$%s = $this->extensions[', $this->getAttribute('var_name')))
			->repr($this->getAttribute('extension_name'))
			->raw("];\n")
			->write(sprintf('$%s->enter($%s = new \Twig\Profiler\Profile($this->getTemplateName(), ', $this->getAttribute('var_name'), $this->getAttribute('var_name') . '_prof'))
			->repr($this->getAttribute('type'))
			->raw(', ')
			->repr($this->getAttribute('name'))
			->raw("));\n\n");
	}

}
