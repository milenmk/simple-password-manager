<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SandboxNode.php
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

namespace Twig\Node;

use Twig\Compiler;

/**
 * Represents a sandbox node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SandboxNode extends Node
{

	public function __construct(Node $body, int $lineno, string $tag = null)
	{

		parent::__construct(['body' => $body], [], $lineno, $tag);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler
			->addDebugInfo($this)
			->write("if (!\$alreadySandboxed = \$this->sandbox->isSandboxed()) {\n")
			->indent()
			->write("\$this->sandbox->enableSandbox();\n")
			->outdent()
			->write("}\n")
			->write("try {\n")
			->indent()
			->subcompile($this->getNode('body'))
			->outdent()
			->write("} finally {\n")
			->indent()
			->write("if (!\$alreadySandboxed) {\n")
			->indent()
			->write("\$this->sandbox->disableSandbox();\n")
			->outdent()
			->write("}\n")
			->outdent()
			->write("}\n");
	}

}
