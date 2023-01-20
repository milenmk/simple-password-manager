<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: functions.lib.php
 *  Last Modified: 19.01.23 г., 22:46 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       3.0.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        functions.lib.php
 * \ingroup     Password Manager
 * \brief       File to hold global functions
 */

declare(strict_types=1);

const PM_LOG_EMERG = 0;
const PM_LOG_ALERT = 1;
const PM_LOG_CRIT = 2;
const PM_LOG_ERR = 3;
const PM_LOG_WARNING = 4;
const PM_LOG_NOTICE = 5;
const PM_LOG_INFO = 6;
const PM_LOG_DEBUG = 7;

/**
 *  Write log message into outputs. Possible outputs can be:
 *  This must not use any call to other function calling pm_syslog (avoid infinite loop).
 *
 * @param string $message                         Line to log. ''=Show nothing
 * @param int    $level                           Log level
 *                                                On Windows PM_LOG_ERR=4, PM_LOG_WARNING=5,
 *                                                PM_LOG_NOTICE=PM_LOG_INFO=6, PM_LOG_DEBUG=6
 *                                                On Linux   PM_LOG_ERR=3, PM_LOG_WARNING=4,
 *                                                PM_LOG_NOTICE=5, PM_LOG_INFO=6, PM_LOG_DEBUG=7
 *
 * @return    void
 * @throws Exception
 */
function pm_syslog(string $message, int $level)
{

    global $user;

    if (!empty($message)) {
        // Test log level
        $log_levels = [
            PM_LOG_EMERG   => 'EMERG',
            PM_LOG_ALERT   => 'ALERT',
            PM_LOG_CRIT    => 'CRITICAL',
            PM_LOG_ERR     => 'ERR',
            PM_LOG_WARNING => 'WARN',
            PM_LOG_NOTICE  => 'NOTICE',
            PM_LOG_INFO    => 'INFO',
            PM_LOG_DEBUG   => 'DEBUG',
        ];
        if (!array_key_exists($level, $log_levels) || empty($level)) {
            $level = PM_LOG_DEBUG;
        }

        $data = [
            'message' => $message,
            'script'  => (isset($_SERVER['PHP_SELF']) ? basename($_SERVER['PHP_SELF'], '.php') : false),
            'level'   => $level,
            'user'    => ((is_object($user) && isset($user->id)) ? $user->username : false),
            'ip'      => false,
        ];
        $remoteip = getUserRemoteIP();
        // Get ip when page run on a web server
        if (!empty($remoteip)) {
            $data['ip'] = $remoteip;
            // This is when server run behind a reverse proxy
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != $remoteip) {
                $data['ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'] . ' -> ' . $data['ip'];
            } elseif (!empty($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != $remoteip) {
                $data['ip'] = $_SERVER['HTTP_CLIENT_IP'] . ' -> ' . $data['ip'];
            }
        }

        pm_export($data);
        unset($data);
    }
}

/**
 * Export the message
 *
 * @param array $content Array containing the info about the message
 *
 * @return    void
 */
function pm_export(array $content)
{

    $logfile = PM_MAIN_DOCUMENT_ROOT . '/pm-log.log';
    //Unlock file for writing
    if (isset($_SERVER['WINDIR'])) {
        // Host OS is Windows
        exec('attrib -R ' . escapeshellarg($logfile), $res);
        $res = $res[0];
    } else {
        // Host OS is *nix
        chmod($logfile, 0755);
    }

    $filefd = fopen($logfile, 'a+');
    if (!$filefd) {
        // Do not break usage if log fails
        //throw new Exception('Failed to open log file '.basename($logfile));
        print 'Failed to open log file ' . basename($logfile);
    } else {
        $log_levels = [
            PM_LOG_EMERG   => 'EMERG',
            PM_LOG_ALERT   => 'ALERT',
            PM_LOG_CRIT    => 'CRIT',
            PM_LOG_ERR     => 'ERR',
            PM_LOG_WARNING => 'WARNING',
            PM_LOG_NOTICE  => 'NOTICE',
            PM_LOG_INFO    => 'INFO',
            PM_LOG_DEBUG   => 'DEBUG',
        ];
        $message = date('Y-m-d H:i:s') . ' ' .
                   sprintf('%-7s', $log_levels[$content['level']]) . ' ' .
                   sprintf('%-15s', $content['ip']) . ' ' . $content['message'];
        fwrite($filefd, $message . "\n");
        fclose($filefd);
        //Lock file as read only
        if (isset($_SERVER['WINDIR'])) {
            // Host OS is Windows
            exec('attrib +R ' . escapeshellarg($logfile), $res);
            $res = $res[0];
        } else {
            // Host OS is *nix
            chmod($logfile, 0444);
        }
    }
}

/**
 * Return the IP of remote user.
 * Take HTTP_X_FORWARDED_FOR (defined when using proxy)
 * Then HTTP_CLIENT_IP if defined (rare)
 * Then REMOTE_ADDR (no way to be modified by user but may be wrong if user is using a proxy)
 *
 * @return    string        Ip of remote user.
 */
function getUserRemoteIP(): string
{

    if (empty($_SERVER['HTTP_X_FORWARDED_FOR']) || preg_match('/[^0-9.:,\[\]]/', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (empty($_SERVER['HTTP_CLIENT_IP']) || preg_match('/[^0-9.:,\[\]]/', $_SERVER['HTTP_CLIENT_IP'])) {
            if (empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
                $ip = (empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR']);
            } else {
                $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
            }
        } else {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    } else {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    if (empty($ip)) {
        if (!empty($_SERVER['SERVER_ADDR'])) {
            // This is when PHP session is running inside a web server
            // but not inside a client request (example: init code of apache)
            $data['ip'] = $_SERVER['SERVER_ADDR'];
        } elseif (!empty($_SERVER['COMPUTERNAME'])) {
            // This is when PHP session is running outside a web server,
            // like from Windows command line (Not always defined, but useful if OS defined it).
            $data['ip'] = $_SERVER['COMPUTERNAME'] . (empty($_SERVER['USERNAME']) ? '' : '@' . $_SERVER['USERNAME']);
        } elseif (!empty($_SERVER['LOGNAME'])) {
            // This is when PHP session is running outside a web server,
            // like from Linux command line (Not always defined, but useful if OS defined it).
            $data['ip'] = '???@' . $_SERVER['LOGNAME'];
        }
    }

    return $ip;
}

/**
 *  Return value of a param into GET or POST super variable.
 *
 * @param string     $paramname  Name of parameter to found
 * @param string     $check      Type of check
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
 *                               'san_alpha'=Use filter_var with FILTER_SANITIZE_STRING
 *                               (do not use this for free text string)
 *                               'nohtml'=check there is no html content and no " and no ../
 *                               'restricthtml'=check html content is restricted to some tags only
 *                               'custom'= custom filter specify $filter and $options)
 * @param int|null   $filter     Filter to apply when $check is set to 'custom'.
 *                               (See http://php.net/manual/en/filter.filters.php for details)
 * @param mixed|null $options    Options to pass to filter_var when $check is set to 'custom'
 *
 * @return string|array         Value found (string or array), or '' if check fails
 */
function GETPOST(
    string $paramname,
    string $check = 'alphanohtml',
    int $filter = null,
    mixed $options = null
) {

    if (empty($paramname)) {
        return 'BadFirstParameterForGETPOST';
    }

    $out = $_GET[$paramname] ?? ($_POST[$paramname] ?? '');

    // Check rule
    if (preg_match('/^array/', $check)) {
        // If 'array' or 'array:restricthtml' or 'array:aZ09'
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
 * @param string     $out     Value to check/clear.
 * @param string     $check   Type of check/sanitizing
 * @param int|null   $filter  Filter to apply when $check is set to 'custom'.
 *                            (See http://php.net/manual/en/filter.filters.php for details)
 * @param mixed|null $options Options to pass to filter_var when $check is set to 'custom'
 *
 * @return string|array         Value sanitized (string or array). It may be '' if format check fails.
 */
function checkVal(string $out = '', string $check = 'alphanohtml', int $filter = null, mixed $options = null)
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
            //$out = filter_var($out, FILTER_SANITIZE_STRING);
            $out = htmlspecialchars($out);

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
                    $out = str_ireplace(
                        [
                            '&#38', '&#0000038', '&#x26', '&quot', '&#34', '&#0000034',
                            '&#x22', '"', '&#47', '&#0000047', '&#92', '&#0000092',
                            '&#x2F', '../', '..\\',
                        ],
                        '',
                        $out
                    );
                } while ($oldstringtoclean != $out);
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
 * @param int    $removelinefeed      1=Replace all new lines by 1 space, 0=Only ending new lines
 *                                    are removed others are replaced with \n,
 *                                    2=Ending new lines are removed but
 *                                    others are kept with a same number of \n than nb of <br>
 *                                    when there is both "...<br>\n..."
 * @param int    $strip_tags          0=Use internal strip, 1=Use strip_tags() php function
 *                                    (bugged when text contains a < char that is not
 *                                    for a html tag or when tags are not
 *                                    closed like '<img onload=aaa')
 * @param int    $removedoublespaces  Replace double space into one space
 *
 * @return string                        String cleaned
 *
 */
function string_nohtmltag(
    string $stringtoclean,
    int $removelinefeed = 1,
    int $strip_tags = 0,
    int $removedoublespaces = 1
): string {

    if ($removelinefeed == 2) {
        $stringtoclean = preg_replace('/<br[^>]*>([\n\r])+/im', '<br>', $stringtoclean);
    }
    $temp = preg_replace('/<br[^>]*>/i', "\n", $stringtoclean);
    $temp = str_replace('< ', '__ltspace__', $temp);
    if ($strip_tags) {
        $temp = strip_tags($temp);
    } else {
        $temp = str_replace('<>', '', $temp);
        // No reason to have this into a text, except if value is to try bypass the next html cleaning
        $pattern = '/<[^<>]+>/';
        // Example of $temp: <a href="/myurl" title="<u>A title</u>">0000-021</a>
        $temp = preg_replace($pattern, '', $temp);
        // pass 1 - $temp after pass 1: <a href="/myurl" title="A title">0000-021
        $temp = preg_replace($pattern, '', $temp);
        // pass 2 - $temp after pass 2: 0000-021
        // Remove '<' into remainging, so remove non closing html tags like
        // '<abc' or '<<abc'. Note: '<123abc' is not a html tag (can be kept),
        // but '<abc123' is (must be removed).
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
function get_osencode(string $str): string
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

/**
 * Global block to redirect on logout
 *
 * @return void
 */
function pm_logout_block()
{

    global $action;
    if ($action == 'logout') {
        session_unset();
        // Destroy the session.
        session_destroy();
        header('Location: ' . PM_MAIN_URL_ROOT);
    }
}
