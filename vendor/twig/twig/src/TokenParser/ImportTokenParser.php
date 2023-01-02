<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ImportTokenParser.php
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
 *   {% import 'forms.html' as forms %}
 *
 * @internal
 */
final class ImportTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$macro = $this->parser->getExpressionParser()->parseExpression();
		$this->parser->getStream()->expect(/* Token::NAME_TYPE */ 5, 'as');
		$var = new AssignNameExpression($this->parser->getStream()->expect(/* Token::NAME_TYPE */ 5)->getValue(), $token->getLine());
		$this->parser->getStream()->expect(/* Token::BLOCK_END_TYPE */ 3);

		$this->parser->addImportedSymbol('template', $var->getAttribute('name'));

		return new ImportNode($macro, $var, $token->getLine(), $this->getTag(), $this->parser->isMainScope());
	}

	public function getTag(): string
	{

		return 'import';
	}

}
