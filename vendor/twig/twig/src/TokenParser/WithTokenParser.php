<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: WithTokenParser.php
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

namespace Twig\TokenParser;

use Twig\Node\Node;
use Twig\Node\WithNode;
use Twig\Token;

/**
 * Creates a nested scope.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
final class WithTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$stream = $this->parser->getStream();

		$variables = null;
		$only = false;
		if (!$stream->test(/* Token::BLOCK_END_TYPE */ 3)) {
			$variables = $this->parser->getExpressionParser()->parseExpression();
			$only = (bool)$stream->nextIf(/* Token::NAME_TYPE */ 5, 'only');
		}

		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		$body = $this->parser->subparse([$this, 'decideWithEnd'], true);

		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		return new WithNode($body, $variables, $only, $token->getLine(), $this->getTag());
	}

	public function getTag(): string
	{

		return 'with';
	}

	public function decideWithEnd(Token $token): bool
	{

		return $token->test('endwith');
	}

}
