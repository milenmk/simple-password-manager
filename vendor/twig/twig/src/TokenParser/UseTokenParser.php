<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UseTokenParser.php
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

use Twig\Error\SyntaxError;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\Token;

/**
 * Imports blocks defined in another template into the current template.
 *
 *    {% extends "base.html" %}
 *
 *    {% use "blocks.html" %}
 *
 *    {% block title %}{% endblock %}
 *    {% block content %}{% endblock %}
 *
 * @see https://twig.symfony.com/doc/templates.html#horizontal-reuse for details.
 *
 * @internal
 */
final class UseTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$template = $this->parser->getExpressionParser()->parseExpression();
		$stream = $this->parser->getStream();

		if (!$template instanceof ConstantExpression) {
			throw new SyntaxError('The template references in a "use" statement must be a string.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
		}

		$targets = [];
		if ($stream->nextIf('with')) {
			do {
				$name = $stream->expect(/* Token::NAME_TYPE */ 5)->getValue();

				$alias = $name;
				if ($stream->nextIf('as')) {
					$alias = $stream->expect(/* Token::NAME_TYPE */ 5)->getValue();
				}

				$targets[$name] = new ConstantExpression($alias, -1);

				if (!$stream->nextIf(/* Token::PUNCTUATION_TYPE */ 9, ',')) {
					break;
				}
			}
			while (true);
		}

		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		$this->parser->addTrait(new Node(['template' => $template, 'targets' => new Node($targets)]));

		return new Node();
	}

	public function getTag(): string
	{

		return 'use';
	}

}
