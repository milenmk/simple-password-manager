<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ApplyTokenParser.php
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

namespace Twig\TokenParser;

use Twig\Node\Expression\TempNameExpression;
use Twig\Node\Node;
use Twig\Node\PrintNode;
use Twig\Node\SetNode;
use Twig\Token;

/**
 * Applies filters on a section of a template.
 *
 *   {% apply upper %}
 *      This text becomes uppercase
 *   {% endapply %}
 *
 * @internal
 */
final class ApplyTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$lineno = $token->getLine();
		$name = $this->parser->getVarName();

		$ref = new TempNameExpression($name, $lineno);
		$ref->setAttribute('always_defined', true);

		$filter = $this->parser->getExpressionParser()->parseFilterExpressionRaw($ref, $this->getTag());

		$this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
		$body = $this->parser->subparse([$this, 'decideApplyEnd'], true);
		$this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

		return new Node(
			[
				new SetNode(true, $ref, $body, $lineno, $this->getTag()),
				new PrintNode($filter, $lineno, $this->getTag()),
			]
		);
	}

	public function getTag(): string
	{

		return 'apply';
	}

	public function decideApplyEnd(Token $token): bool
	{

		return $token->test('endapply');
	}

}
