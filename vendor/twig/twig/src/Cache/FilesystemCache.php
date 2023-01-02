<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FilesystemCache.php
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

namespace Twig\Cache;

use RuntimeException;
use function dirname;
use function function_exists;
use const FILTER_VALIDATE_BOOLEAN;
use const PHP_VERSION_ID;

/**
 * Implements a cache on the filesystem.
 *
 * @author Andrew Tch <andrew@noop.lv>
 */
class FilesystemCache implements CacheInterface
{

	public const FORCE_BYTECODE_INVALIDATION = 1;

	private $directory;
	private $options;

	public function __construct(string $directory, int $options = 0)
	{

		$this->directory = rtrim($directory, '\/') . '/';
		$this->options = $options;
	}

	public function generateKey(string $name, string $className): string
	{

		$hash = hash(PHP_VERSION_ID < 80100 ? 'sha256' : 'xxh128', $className);

		return $this->directory . $hash[0] . $hash[1] . '/' . $hash . '.php';
	}

	public function load(string $key): void
	{

		if (is_file($key)) {
			@include_once $key;
		}
	}

	public function write(string $key, string $content): void
	{

		$dir = dirname($key);
		if (!is_dir($dir)) {
			if (false === @mkdir($dir, 0777, true)) {
				clearstatcache(true, $dir);
				if (!is_dir($dir)) {
					throw new RuntimeException(sprintf('Unable to create the cache directory (%s).', $dir));
				}
			}
		} elseif (!is_writable($dir)) {
			throw new RuntimeException(sprintf('Unable to write in the cache directory (%s).', $dir));
		}

		$tmpFile = tempnam($dir, basename($key));
		if (false !== @file_put_contents($tmpFile, $content) && @rename($tmpFile, $key)) {
			@chmod($key, 0666 & ~umask());

			if (self::FORCE_BYTECODE_INVALIDATION == ($this->options & self::FORCE_BYTECODE_INVALIDATION)) {
				// Compile cached file into bytecode cache
				if (function_exists('opcache_invalidate') && filter_var(ini_get('opcache.enable'), FILTER_VALIDATE_BOOLEAN)) {
					@opcache_invalidate($key, true);
				} elseif (function_exists('apc_compile_file')) {
					apc_compile_file($key);
				}
			}

			return;
		}

		throw new RuntimeException(sprintf('Failed to write cache file "%s".', $key));
	}

	public function getTimestamp(string $key): int
	{

		if (!is_file($key)) {
			return 0;
		}

		return (int)@filemtime($key);
	}

}
