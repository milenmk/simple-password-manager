<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: IncludeNode.php
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

namespace Twig\Node;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;

/**
 * Represents an include node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class IncludeNode extends Node implements NodeOutputInterface
{

	public function __construct(AbstractExpression $expr, ?AbstractExpression $variables, bool $only, bool $ignoreMissing, int $lineno, string $tag = null)
	{

		$nodes = ['expr' => $expr];
		if (null !== $variables) {
			$nodes['variables'] = $variables;
		}

		parent::__construct($nodes, ['only' => $only, 'ignore_missing' => $ignoreMissing], $lineno, $tag);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler->addDebugInfo($this);

		if ($this->getAttribute('ignore_missing')) {
			$template = $compiler->getVarName();

			$compiler
				->write(sprintf("$%s = null;\n", $template))
				->write("try {\n")
				->indent()
				->write(sprintf('$%s = ', $template));

			$this->addGetTemplate($compiler);

			$compiler
				->raw(";\n")
				->outdent()
				->write("} catch (LoaderError \$e) {\n")
				->indent()
				->write("// ignore missing template\n")
				->outdent()
				->write("}\n")
				->write(sprintf("if ($%s) {\n", $template))
				->indent()
				->write(sprintf('$%s->display(', $template));
			$this->addTemplateArguments($compiler);
			$compiler
				->raw(");\n")
				->outdent()
				->write("}\n");
		} else {
			$this->addGetTemplate($compiler);
			$compiler->raw('->display(');
			$this->addTemplateArguments($compiler);
			$compiler->raw(");\n");
		}
	}

	protected function addGetTemplate(Compiler $compiler)
	{

		$compiler
			->write('$this->loadTemplate(')
			->subcompile($this->getNode('expr'))
			->raw(', ')
			->repr($this->getTemplateName())
			->raw(', ')
			->repr($this->getTemplateLine())
			->raw(')');
	}

	protected function addTemplateArguments(Compiler $compiler)
	{

		if (!$this->hasNode('variables')) {
			$compiler->raw(false === $this->getAttribute('only') ? '$context' : '[]');
		} elseif (false === $this->getAttribute('only')) {
			$compiler
				->raw('twig_array_merge($context, ')
				->subcompile($this->getNode('variables'))
				->raw(')');
		} else {
			$compiler->raw('twig_to_array(');
			$compiler->subcompile($this->getNode('variables'));
			$compiler->raw(')');
		}
	}

}
