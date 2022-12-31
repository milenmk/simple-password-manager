<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: CheckToStringNode.php
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

/**
 * Checks if casting an expression to __toString() is allowed by the sandbox.
 *
 * For instance, when there is a simple Print statement, like {{ article }},
 * and if the sandbox is enabled, we need to check that the __toString()
 * method is allowed if 'article' is an object. The same goes for {{ article|upper }}
 * or {{ random(article) }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CheckToStringNode extends AbstractExpression
{

	public function __construct(AbstractExpression $expr)
	{

		parent::__construct(['expr' => $expr], [], $expr->getTemplateLine(), $expr->getNodeTag());
	}

	public function compile(Compiler $compiler): void
	{

		$expr = $this->getNode('expr');
		$compiler
			->raw('$this->sandbox->ensureToStringAllowed(')
			->subcompile($expr)
			->raw(', ')
			->repr($expr->getTemplateLine())
			->raw(', $this->source)');
	}

}
