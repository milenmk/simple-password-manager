<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FromTokenParser.php
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

use Twig\Node\Expression\AssignNameExpression;
use Twig\Node\ImportNode;
use Twig\Node\Node;
use Twig\Token;

/**
 * Imports macros.
 *
 *   {% from 'forms.html' import forms %}
 *
 * @internal
 */
final class FromTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$macro = $this->parser->getExpressionParser()->parseExpression();
		$stream = $this->parser->getStream();
		$stream->expect(/* Token::NAME_TYPE */ 5, 'import');

		$targets = [];
		do {
			$name = $stream->expect(/* Token::NAME_TYPE */ 5)->getValue();

			$alias = $name;
			if ($stream->nextIf('as')) {
				$alias = $stream->expect(/* Token::NAME_TYPE */ 5)->getValue();
			}

			$targets[$name] = $alias;

			if (!$stream->nextIf(/* Token::PUNCTUATION_TYPE */ 9, ',')) {
				break;
			}
		}
		while (true);

		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		$var = new AssignNameExpression($this->parser->getVarName(), $token->getLine());
		$node = new ImportNode($macro, $var, $token->getLine(), $this->getTag(), $this->parser->isMainScope());

		foreach ($targets as $name => $alias) {
			$this->parser->addImportedSymbol('function', $alias, 'macro_' . $name, $var);
		}

		return $node;
	}

	public function getTag(): string
	{

		return 'from';
	}

}
