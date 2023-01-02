<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ArrayExpression.php
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

namespace Twig\Node\Expression;

use Twig\Compiler;

class ArrayExpression extends AbstractExpression
{

	private $index;

	public function __construct(array $elements, int $lineno)
	{

		parent::__construct($elements, [], $lineno);

		$this->index = -1;
		foreach ($this->getKeyValuePairs() as $pair) {
			if ($pair['key'] instanceof ConstantExpression && ctype_digit((string)$pair['key']->getAttribute('value')) && $pair['key']->getAttribute('value') > $this->index) {
				$this->index = $pair['key']->getAttribute('value');
			}
		}
	}

	public function getKeyValuePairs(): array
	{

		$pairs = [];
		foreach (array_chunk($this->nodes, 2) as $pair) {
			$pairs[] = [
				'key'   => $pair[0],
				'value' => $pair[1],
			];
		}

		return $pairs;
	}

	public function hasElement(AbstractExpression $key): bool
	{

		foreach ($this->getKeyValuePairs() as $pair) {
			// we compare the string representation of the keys
			// to avoid comparing the line numbers which are not relevant here.
			if ((string)$key === (string)$pair['key']) {
				return true;
			}
		}

		return false;
	}

	public function addElement(AbstractExpression $value, AbstractExpression $key = null): void
	{

		if (null === $key) {
			$key = new ConstantExpression(++$this->index, $value->getTemplateLine());
		}

		array_push($this->nodes, $key, $value);
	}

	public function compile(Compiler $compiler): void
	{

		$compiler->raw('[');
		$first = true;
		foreach ($this->getKeyValuePairs() as $pair) {
			if (!$first) {
				$compiler->raw(', ');
			}
			$first = false;

			$compiler
				->subcompile($pair['key'])
				->raw(' => ')
				->subcompile($pair['value']);
		}
		$compiler->raw(']');
	}

}
