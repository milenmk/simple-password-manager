<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ProfilerNodeVisitor.php
 *  Last Modified: 31.12.22 г., 22:13 ч.
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

namespace Twig\Profiler\NodeVisitor;

use Twig\Environment;
use Twig\Node\BlockNode;
use Twig\Node\BodyNode;
use Twig\Node\MacroNode;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\Profiler\Node\EnterProfileNode;
use Twig\Profiler\Node\LeaveProfileNode;
use Twig\Profiler\Profile;
use const PHP_VERSION_ID;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class ProfilerNodeVisitor implements NodeVisitorInterface
{

	private $extensionName;
	private $varName;

	public function __construct(string $extensionName)
	{

		$this->extensionName = $extensionName;
		$this->varName = sprintf('__internal_%s', hash(PHP_VERSION_ID < 80100 ? 'sha256' : 'xxh128', $extensionName));
	}

	public function enterNode(Node $node, Environment $env): Node
	{

		return $node;
	}

	public function leaveNode(Node $node, Environment $env): ?Node
	{

		if ($node instanceof ModuleNode) {
			$node->setNode('display_start', new Node([new EnterProfileNode($this->extensionName, Profile::TEMPLATE, $node->getTemplateName(), $this->varName), $node->getNode('display_start')]));
			$node->setNode('display_end', new Node([new LeaveProfileNode($this->varName), $node->getNode('display_end')]));
		} elseif ($node instanceof BlockNode) {
			$node->setNode(
				'body', new BodyNode(
				[
					new EnterProfileNode($this->extensionName, Profile::BLOCK, $node->getAttribute('name'), $this->varName),
					$node->getNode('body'),
					new LeaveProfileNode($this->varName),
				]
			)
			);
		} elseif ($node instanceof MacroNode) {
			$node->setNode(
				'body', new BodyNode(
				[
					new EnterProfileNode($this->extensionName, Profile::MACRO, $node->getAttribute('name'), $this->varName),
					$node->getNode('body'),
					new LeaveProfileNode($this->varName),
				]
			)
			);
		}

		return $node;
	}

	public function getPriority(): int
	{

		return 0;
	}

}
