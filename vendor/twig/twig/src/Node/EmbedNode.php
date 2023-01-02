<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: EmbedNode.php
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
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Expression\ConstantExpression;

/**
 * Represents an embed node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class EmbedNode extends IncludeNode
{

	// we don't inject the module to avoid node visitors to traverse it twice (as it will be already visited in the main module)
	public function __construct(string $name, int $index, ?AbstractExpression $variables, bool $only, bool $ignoreMissing, int $lineno, string $tag = null)
	{

		parent::__construct(new ConstantExpression('not_used', $lineno), $variables, $only, $ignoreMissing, $lineno, $tag);

		$this->setAttribute('name', $name);
		$this->setAttribute('index', $index);
	}

	protected function addGetTemplate(Compiler $compiler): void
	{

		$compiler
			->write('$this->loadTemplate(')
			->string($this->getAttribute('name'))
			->raw(', ')
			->repr($this->getTemplateName())
			->raw(', ')
			->repr($this->getTemplateLine())
			->raw(', ')
			->string($this->getAttribute('index'))
			->raw(')');
	}

}
