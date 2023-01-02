<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SandboxExtension.php
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

namespace Twig\Extension;

use Twig\NodeVisitor\SandboxNodeVisitor;
use Twig\Sandbox\SecurityNotAllowedMethodError;
use Twig\Sandbox\SecurityNotAllowedPropertyError;
use Twig\Sandbox\SecurityPolicyInterface;
use Twig\Source;
use Twig\TokenParser\SandboxTokenParser;
use function is_object;

final class SandboxExtension extends AbstractExtension
{

	private $sandboxedGlobally;
	private $sandboxed;
	private $policy;

	public function __construct(SecurityPolicyInterface $policy, $sandboxed = false)
	{

		$this->policy = $policy;
		$this->sandboxedGlobally = $sandboxed;
	}

	public function getTokenParsers(): array
	{

		return [new SandboxTokenParser()];
	}

	public function getNodeVisitors(): array
	{

		return [new SandboxNodeVisitor()];
	}

	public function enableSandbox(): void
	{

		$this->sandboxed = true;
	}

	public function disableSandbox(): void
	{

		$this->sandboxed = false;
	}

	public function isSandboxedGlobally(): bool
	{

		return $this->sandboxedGlobally;
	}

	public function setSecurityPolicy(SecurityPolicyInterface $policy)
	{

		$this->policy = $policy;
	}

	public function getSecurityPolicy(): SecurityPolicyInterface
	{

		return $this->policy;
	}

	public function checkSecurity($tags, $filters, $functions): void
	{

		if ($this->isSandboxed()) {
			$this->policy->checkSecurity($tags, $filters, $functions);
		}
	}

	public function isSandboxed(): bool
	{

		return $this->sandboxedGlobally || $this->sandboxed;
	}

	public function checkPropertyAllowed($obj, $property, int $lineno = -1, Source $source = null): void
	{

		if ($this->isSandboxed()) {
			try {
				$this->policy->checkPropertyAllowed($obj, $property);
			}
			catch (SecurityNotAllowedPropertyError $e) {
				$e->setSourceContext($source);
				$e->setTemplateLine($lineno);

				throw $e;
			}
		}
	}

	public function ensureToStringAllowed($obj, int $lineno = -1, Source $source = null)
	{

		if ($this->isSandboxed() && is_object($obj) && method_exists($obj, '__toString')) {
			try {
				$this->policy->checkMethodAllowed($obj, '__toString');
			}
			catch (SecurityNotAllowedMethodError $e) {
				$e->setSourceContext($source);
				$e->setTemplateLine($lineno);

				throw $e;
			}
		}

		return $obj;
	}

	public function checkMethodAllowed($obj, $method, int $lineno = -1, Source $source = null): void
	{

		if ($this->isSandboxed()) {
			try {
				$this->policy->checkMethodAllowed($obj, $method);
			}
			catch (SecurityNotAllowedMethodError $e) {
				$e->setSourceContext($source);
				$e->setTemplateLine($lineno);

				throw $e;
			}
		}
	}

}
