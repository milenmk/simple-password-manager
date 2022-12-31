<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DefaultFilter.php
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

namespace Twig\Node\Expression\Filter;

use Twig\Compiler;
use Twig\Node\Expression\ConditionalExpression;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Expression\FilterExpression;
use Twig\Node\Expression\GetAttrExpression;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Expression\Test\DefinedTest;
use Twig\Node\Node;
use function count;

/**
 * Returns the value or the default value when it is undefined or empty.
 *
 *  {{ var.foo|default('foo item on var is not defined') }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DefaultFilter extends FilterExpression
{

	public function __construct(Node $node, ConstantExpression $filterName, Node $arguments, int $lineno, string $tag = null)
	{

		$default = new FilterExpression($node, new ConstantExpression('default', $node->getTemplateLine()), $arguments, $node->getTemplateLine());

		if ('default' === $filterName->getAttribute('value') && ($node instanceof NameExpression || $node instanceof GetAttrExpression)) {
			$test = new DefinedTest(clone $node, 'defined', new Node(), $node->getTemplateLine());
			$false = count($arguments) ? $arguments->getNode(0) : new ConstantExpression('', $node->getTemplateLine());

			$node = new ConditionalExpression($test, $default, $false, $node->getTemplateLine());
		} else {
			$node = $default;
		}

		parent::__construct($node, $filterName, $arguments, $lineno, $tag);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler->subcompile($this->getNode('node'));
	}

}
