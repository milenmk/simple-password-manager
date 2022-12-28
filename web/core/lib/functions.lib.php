<?php /** @noinspection PhpFunctionNamingConventionInspection */

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: functions.lib.php
 *  Last Modified: 25.12.22 г., 20:02 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0
 * @version       1.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 **/

declare(strict_types = 1);

/**
 * \file        class/functions.lib.php
 * \ingroup     ${MODULE_NAME}
 * \brief       This file is a CRUD class file for ${MODULE_NAME} (Create/Read/Update/Delete)
 */

/**
 *  Return value of a param into GET or POST super variable.
 *
 * @param string $paramname      Name of parameter to found
 * @param string $check          Type of check
 *                               ''=no check (deprecated)
 *                               'none'=no check (only for param that should have very rich content)
 *                               'array', 'array:restricthtml' or 'array:aZ09' to check it's an array
 *                               'int'=check it's numeric (integer or float)
 *                               'intcomma'=check it's integer+comma ('1,2,3,4...')
 *                               'alpha'=Same than alphanohtml since v13
 *                               'alphawithlgt'=alpha with lgt
 *                               'alphanohtml'=check there is no html content and no " and no ../
 *                               'aZ'=check it's a-z only
 *                               'aZ09'=check it's simple alpha string (recommended for keys)
 *                               'san_alpha'=Use filter_var with FILTER_SANITIZE_STRING (do not use this for free text string)
 *                               'nohtml'=check there is no html content and no " and no ../
 *                               'restricthtml'=check html content is restricted to some tags only
 *                               'custom'= custom filter specify $filter and $options)
 * @param int    $method         Type of method (0 = get then post, 1 = only get, 2 = only post, 3 = post then get)
 * @param int    $filter         Filter to apply when $check is set to 'custom'. (See http://php.net/manual/en/filter.filters.php for details)
 * @param mixed  $options        Options to pass to filter_var when $check is set to 'custom'
 *
 * @return string|array         Value found (string or array), or '' if check fails
 */
function GETPOST($paramname, $check = 'alphanohtml', $method = 0, $filter = null, $options = null)
{

	if (empty($paramname)) {
		return 'BadFirstParameterForGETPOST';
	}

	if (empty($method)) {
		$out = $_GET[$paramname] ?? ($_POST[$paramname] ?? '');
	} elseif ($method == 1) {
		$out = $_GET[$paramname] ?? '';
	} elseif ($method == 2) {
		$out = $_POST[$paramname] ?? '';
	} elseif ($method == 3) {
		$out = $_POST[$paramname] ?? ($_GET[$paramname] ?? '');
	} else {
		return 'BadThirdParameterForGETPOST';
	}

	// Check rule
	if (preg_match('/^array/', $check)) {    // If 'array' or 'array:restricthtml' or 'array:aZ09'
		if (!is_array($out) || empty($out)) {
			$out = [];
		} else {
			$tmparray = explode(':', $check);
			if (!empty($tmparray[1])) {
				$tmpcheck = $tmparray[1];
			} else {
				$tmpcheck = 'alphanohtml';
			}
			foreach ($out as $outkey => $outval) {
				$out[$outkey] = checkVal($outval, $tmpcheck, $filter, $options);
			}
		}
	} else {
		$out = checkVal($out, $check, $filter, $options);
	}

	return $out;
}

/**
 *  Return a value after checking on a rule. A sanitization may also have been done.
 *
 * @param string $out     Value to check/clear.
 * @param string $check   Type of check/sanitizing
 * @param int    $filter  Filter to apply when $check is set to 'custom'. (See http://php.net/manual/en/filter.filters.php for details)
 * @param mixed  $options Options to pass to filter_var when $check is set to 'custom'
 *
 * @return string|array         Value sanitized (string or array). It may be '' if format check fails.
 */
function checkVal($out = '', $check = 'alphanohtml', $filter = null, $options = null)
{

	// Check is done after replacement
	switch ($check) {
		case 'none':
			break;
		case 'int':    // Check param is a numeric value (integer but also float or hexadecimal)
			if (!is_numeric($out)) {
				$out = '';
			}
			break;
		case 'intcomma':
			if (preg_match('/[^0-9,-]+/i', $out)) {
				$out = '';
			}
			break;
		case 'san_alpha':
			$out = filter_var($out, FILTER_SANITIZE_STRING);
			break;
		case 'email':
			$out = filter_var($out, FILTER_SANITIZE_EMAIL);
			break;
		case 'aZ':
			if (!is_array($out)) {
				$out = trim($out);
				if (preg_match('/[^a-z]+/i', $out)) {
					$out = '';
				}
			}
			break;
		case 'aZ09':
			if (!is_array($out)) {
				$out = trim($out);
				if (preg_match('/[^a-z0-9_\-.]+/i', $out)) {
					$out = '';
				}
			}
			break;
		case 'aZ09comma':        // great to sanitize sortfield or sortorder params that can be t.abc,t.def_gh
			if (!is_array($out)) {
				$out = trim($out);
				if (preg_match('/[^a-z0-9_\-.,]+/i', $out)) {
					$out = '';
				}
			}
			break;
		case 'nohtml':        // No html
			$out = string_nohtmltag($out, 0);
			break;
		case 'alpha':        // No html and no ../ and "
		case 'alphanohtml':    // Recommended for most scalar parameters and search parameters
			if (!is_array($out)) {
				$out = trim($out);
				do {
					$oldstringtoclean = $out;
					// Remove html tags
					$out = string_nohtmltag($out, 0);
					$out = str_ireplace(['&#38', '&#0000038', '&#x26', '&quot', '&#34', '&#0000034', '&#x22', '"', '&#47', '&#0000047', '&#92', '&#0000092', '&#x2F', '../', '..\\'], '', $out);
				}
				while ($oldstringtoclean != $out);
			}
			break;
		case 'custom':
			if (empty($filter)) {
				return 'BadFourthParameterForGETPOST';
			}
			$out = filter_var($out, $filter, $options);
			break;
	}

	return $out;
}

/**
 *    Clean a string from all HTML tags and entities.
 *  This function differs from strip_tags because:
 *  - <br> are replaced with \n if removelinefeed=0 or 1
 *  - if entities are found, they are decoded BEFORE the strip
 *  - you can decide to convert line feed into a space
 *
 * @param string $stringtoclean       String to clean
 * @param int    $removelinefeed      1=Replace all new lines by 1 space, 0=Only ending new lines are removed others are replaced with \n, 2=Ending new lines are removed but
 *                                    others are kept with a same number of \n than nb of <br> when there is both "...<br>\n..."
 * @param int    $strip_tags          0=Use internal strip, 1=Use strip_tags() php function (bugged when text contains a < char that is not for a html tag or when tags are not
 *                                    closed like '<img onload=aaa')
 * @param int    $removedoublespaces  Replace double space into one space
 *
 * @return string                        String cleaned
 *
 */
function string_nohtmltag($stringtoclean, $removelinefeed = 1, $strip_tags = 0, $removedoublespaces = 1)
{

	if ($removelinefeed == 2) {
		$stringtoclean = preg_replace('/<br[^>]*>([\n\r])+/im', '<br>', $stringtoclean);
	}
	$temp = preg_replace('/<br[^>]*>/i', "\n", $stringtoclean);

	$temp = str_replace('< ', '__ltspace__', $temp);

	if ($strip_tags) {
		$temp = strip_tags($temp);
	} else {
		$temp = str_replace('<>', '', $temp);      // No reason to have this into a text, except if value is to try bypass the next html cleaning
		$pattern = '/<[^<>]+>/';
		// Example of $temp: <a href="/myurl" title="<u>A title</u>">0000-021</a>
		$temp = preg_replace($pattern, '', $temp); // pass 1 - $temp after pass 1: <a href="/myurl" title="A title">0000-021
		$temp = preg_replace($pattern, '', $temp); // pass 2 - $temp after pass 2: 0000-021
		// Remove '<' into remainging, so remove non closing html tags like '<abc' or '<<abc'. Note: '<123abc' is not a html tag (can be kept), but '<abc123' is (must be removed).
		$temp = preg_replace('/<+([a-z]+)/i', '\1', $temp);
	}

	// Remove also carriage returns
	if ($removelinefeed == 1) {
		$temp = str_replace(["\r\n", "\r", "\n"], ' ', $temp);
	}

	// And double quotes
	if ($removedoublespaces) {
		while (strpos($temp, '  ')) {
			$temp = str_replace('  ', ' ', $temp);
		}
	}

	$temp = str_replace('__ltspace__', '< ', $temp);

	return trim($temp);
}

/**
 *      Return a string encoded into OS filesystem encoding. This function is used to define
 *        value to pass to filesystem PHP functions.
 *
 * @param string $str String to encode (UTF-8)
 *
 * @return    string                Encoded string (UTF-8, ISO-8859-1)
 */
function get_osencode($str)
{
	$tmp = ini_get('unicode.filesystem_encoding');
	if (empty($tmp) && !empty($_SERVER['WINDIR'])) {
		$tmp = 'iso-8859-1';
	}
	if (empty($tmp)) {
		$tmp = 'utf-8';
	}

	if ($tmp == 'iso-8859-1') {
		return utf8_decode($str);
	}

	return $str;
}