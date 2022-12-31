<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ExtensionInterface.php
 *  Last Modified: 30.12.22 г., 5:54 ч.
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

namespace Twig\Extension;

use Twig\ExpressionParser;
use Twig\Node\Expression\Binary\AbstractBinary;
use Twig\Node\Expression\Unary\AbstractUnary;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\TokenParser\TokenParserInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Interface implemented by extension classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface ExtensionInterface
{

	/**
	 * Returns the token parser instances to add to the existing list.
	 *
	 * @return TokenParserInterface[]
	 */
	public function getTokenParsers();

	/**
	 * Returns the node visitor instances to add to the existing list.
	 *
	 * @return NodeVisitorInterface[]
	 */
	public function getNodeVisitors();

	/**
	 * Returns a list of filters to add to the existing list.
	 *
	 * @return TwigFilter[]
	 */
	public function getFilters();

	/**
	 * Returns a list of tests to add to the existing list.
	 *
	 * @return TwigTest[]
	 */
	public function getTests();

	/**
	 * Returns a list of functions to add to the existing list.
	 *
	 * @return TwigFunction[]
	 */
	public function getFunctions();

	/**
	 * Returns a list of operators to add to the existing list.
	 *
	 * @return array<array> First array of unary operators, second array of binary operators
	 *
	 * @psalm-return array{
	 *     array<string, array{precedence: int, class: class-string<AbstractUnary>}>,
	 *     array<string, array{precedence: int, class: class-string<AbstractBinary>, associativity: ExpressionParser::OPERATOR_*}>
	 * }
	 */
	public function getOperators();

}
