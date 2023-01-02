<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Node.php
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

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use LogicException;
use ReturnTypeWillChange;
use Traversable;
use Twig\Compiler;
use Twig\Source;
use function array_key_exists;
use function count;
use function get_class;
use function gettype;
use function is_object;
use function strlen;

/**
 * Represents a node in the AST.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Node implements Countable, IteratorAggregate
{

	protected $nodes;
	protected $attributes;
	protected $lineno;
	protected $tag;

	private $name;
	private $sourceContext;

	/**
	 * @param array  $nodes      An array of named nodes
	 * @param array  $attributes An array of attributes (should not be nodes)
	 * @param int    $lineno     The line number
	 * @param string $tag        The tag name associated with the Node
	 */
	public function __construct(array $nodes = [], array $attributes = [], int $lineno = 0, string $tag = null)
	{

		foreach ($nodes as $name => $node) {
			if (!$node instanceof self) {
				throw new InvalidArgumentException(sprintf('Using "%s" for the value of node "%s" of "%s" is not supported. You must pass a \Twig\Node\Node instance.', is_object($node) ? get_class($node) : (null === $node ? 'null' : gettype($node)), $name, static::class));
			}
		}
		$this->nodes = $nodes;
		$this->attributes = $attributes;
		$this->lineno = $lineno;
		$this->tag = $tag;
	}

	public function __toString()
	{

		$attributes = [];
		foreach ($this->attributes as $name => $value) {
			$attributes[] = sprintf('%s: %s', $name, str_replace("\n", '', var_export($value, true)));
		}

		$repr = [static::class . '(' . implode(', ', $attributes)];

		if (count($this->nodes)) {
			foreach ($this->nodes as $name => $node) {
				$len = strlen($name) + 4;
				$noderepr = [];
				foreach (explode("\n", (string)$node) as $line) {
					$noderepr[] = str_repeat(' ', $len) . $line;
				}

				$repr[] = sprintf('  %s: %s', $name, ltrim(implode("\n", $noderepr)));
			}

			$repr[] = ')';
		} else {
			$repr[0] .= ')';
		}

		return implode("\n", $repr);
	}

	/**
	 * @return void
	 */
	public function compile(Compiler $compiler)
	{

		foreach ($this->nodes as $node) {
			$node->compile($compiler);
		}
	}

	public function getTemplateLine(): int
	{

		return $this->lineno;
	}

	public function getNodeTag(): ?string
	{

		return $this->tag;
	}

	public function hasAttribute(string $name): bool
	{

		return array_key_exists($name, $this->attributes);
	}

	public function getAttribute(string $name)
	{

		if (!array_key_exists($name, $this->attributes)) {
			throw new LogicException(sprintf('Attribute "%s" does not exist for Node "%s".', $name, static::class));
		}

		return $this->attributes[$name];
	}

	public function setAttribute(string $name, $value): void
	{

		$this->attributes[$name] = $value;
	}

	public function removeAttribute(string $name): void
	{

		unset($this->attributes[$name]);
	}

	public function hasNode(string $name): bool
	{

		return isset($this->nodes[$name]);
	}

	public function getNode(string $name): self
	{

		if (!isset($this->nodes[$name])) {
			throw new LogicException(sprintf('Node "%s" does not exist for Node "%s".', $name, static::class));
		}

		return $this->nodes[$name];
	}

	public function setNode(string $name, self $node): void
	{

		$this->nodes[$name] = $node;
	}

	public function removeNode(string $name): void
	{

		unset($this->nodes[$name]);
	}

	/**
	 * @return int
	 */
	#[ReturnTypeWillChange]
	public function count()
	{

		return count($this->nodes);
	}

	public function getIterator(): Traversable
	{

		return new ArrayIterator($this->nodes);
	}

	public function getTemplateName(): ?string
	{

		return $this->sourceContext ? $this->sourceContext->getName() : null;
	}

	public function getSourceContext(): ?Source
	{

		return $this->sourceContext;
	}

	public function setSourceContext(Source $source): void
	{

		$this->sourceContext = $source;
		foreach ($this->nodes as $node) {
			$node->setSourceContext($source);
		}
	}

}
