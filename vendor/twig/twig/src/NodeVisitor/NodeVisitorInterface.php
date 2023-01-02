<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: NodeVisitorInterface.php
 *  Last Modified: 31.12.22 г., 22:11 ч.
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

namespace Twig\NodeVisitor;

use Twig\Environment;
use Twig\Node\Node;

/**
 * Interface for node visitor classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface NodeVisitorInterface
{

	/**
	 * Called before child nodes are visited.
	 *
	 * @return Node The modified node
	 */
	public function enterNode(Node $node, Environment $env): Node;

	/**
	 * Called after child nodes are visited.
	 *
	 * @return Node|null The modified node or null if the node must be removed
	 */
	public function leaveNode(Node $node, Environment $env): ?Node;

	/**
	 * Returns the priority for this visitor.
	 *
	 * Priority should be between -10 and 10 (0 is the default).
	 *
	 * @return int The priority level
	 */
	public function getPriority();

}
