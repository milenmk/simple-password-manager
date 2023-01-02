<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SandboxTokenParser.php
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
use Twig\Node\IncludeNode;
use Twig\Node\Node;
use Twig\Node\SandboxNode;
use Twig\Node\TextNode;
use Twig\Token;

/**
 * Marks a section of a template as untrusted code that must be evaluated in the sandbox mode.
 *
 *    {% sandbox %}
 *        {% include 'user.html' %}
 *    {% endsandbox %}
 *
 * @see https://twig.symfony.com/doc/api.html#sandbox-extension for details
 *
 * @internal
 */
final class SandboxTokenParser extends AbstractTokenParser
{

	public function parse(Token $token): Node
	{

		$stream = $this->parser->getStream();
		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);
		$body = $this->parser->subparse([$this, 'decideBlockEnd'], true);
		$stream->expect(/* Token::BLOCK_END_TYPE */ 3);

		// in a sandbox tag, only include tags are allowed
		if (!$body instanceof IncludeNode) {
			foreach ($body as $node) {
				if ($node instanceof TextNode && ctype_space($node->getAttribute('data'))) {
					continue;
				}

				if (!$node instanceof IncludeNode) {
					throw new SyntaxError('Only "include" tags are allowed within a "sandbox" section.', $node->getTemplateLine(), $stream->getSourceContext());
				}
			}
		}

		return new SandboxNode($body, $token->getLine(), $this->getTag());
	}

	public function getTag(): string
	{

		return 'sandbox';
	}

	public function decideBlockEnd(Token $token): bool
	{

		return $token->test('endsandbox');
	}

}
