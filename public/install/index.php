<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: index.php
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
 * \file        index.php
 * \ingroup     Password Manager
 * \brief       Pre-checks before install start
 */

declare(strict_types=1);

try {
    include_once('inc.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    print 'File "vendor/autoload.php!"not found';
    die();
}

print $twig->render(
    'install.header.html.twig',
    [
        'langs'    => $langs,
        'main_url' => PM_INSTALL_MAIN_URL,
        'error'    => $errors,
        'message'  => $messages,
        'title'    => $langs->trans('InstallCheck'),
    ]
);

$lockfile = '../../docs/install.lock';
if (file_exists($lockfile)) {
    print $langs->trans('InstallLockfileError');
    exit();
}

print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>
&nbsp;' . $langs->trans('ErrorExplanation') . '<br>';
print '<i class="bi bi-exclamation-circle-fill" style="color: #ffa500;"></i>
&nbsp;' . $langs->trans('WarningExplanation') . '<br>';
print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>
&nbsp;' . $langs->trans('OkExplanation') . '<br>';
print  '<hr>';
$checksok = 1;

//Check PHP version
$phpminversionerror = '7.4.10';
if (version_compare(PHP_VERSION, $phpminversionerror) < 0) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>&nbsp;';
    print $langs->trans('PhpVersionError', PHP_VERSION, $phpminversionerror) . '<br>';
    $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpVersionOk', PHP_VERSION) . '<br>';
}

//Check for POST and GET support
if (!isset($_GET) && !isset($_POST)) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>&nbsp;';
    print $langs->trans('PostGetSupportKo') . '<br>';
    $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PostGetSupportOk') . '<br>';
}

// Check if session_id is enabled
if (!function_exists('session_id')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>&nbsp;';
    print $langs->trans('SessionKo') . '<br>';
    $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('SessionOk') . '<br>';
}

// Check if Curl is supported
if (!function_exists('curl_init')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ffa500;"></i>&nbsp;';
    print $langs->trans('PhpSupportKo', 'CURL') . '<br>';
// $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'CURL') . '<br>';
}

// Check if UTF8 is supported
if (!function_exists('utf8_encode')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ffa500;"></i>&nbsp;';
    print $langs->trans('PhpSupportKo', 'UTF-8') . '<br>';
// $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'UTF-8') . '<br>';
}

// Check if XML is supported
if (!extension_loaded('xml')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ffa500;"></i>&nbsp;';
    print $langs->trans('PhpSupportKo', 'XML') . '<br>';
// $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'XML') . '<br>';
}

// Check if Json is supported
if (!extension_loaded('json')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ffa500;"></i>&nbsp;';
    print $langs->trans('PhpSupportKo', 'JSON') . '<br>';
// $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'JSON') . '<br>';
}

// Check if mbstring is supported
if (!extension_loaded('mbstring')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ffa500;"></i>&nbsp;';
    print $langs->trans('PhpSupportKo', 'MBString') . '<br>';
// $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'MBString') . '<br>';
}

//Check if sodium or OpenSSL are supported
if (extension_loaded('sodium') && extension_loaded('openssl')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'Sodium') . '<br>';
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'OpenSSL') . '<br>';
} elseif (extension_loaded('sodium') && !extension_loaded('openssl')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'Sodium') . '<br>';
} elseif (!extension_loaded('sodium') && extension_loaded('openssl')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'OpenSSL') . '<br>';
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>&nbsp;';
    print $langs->trans('PhpSupportKo', 'Sodium') . '.&nbsp;';
    print $langs->trans('PhpSupportKo', 'OpenSSL') . '<br>';
    $checksok = 0;
}

// Check if PDO is supported
if (!extension_loaded('pdo')) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>&nbsp;';
    print $langs->trans('PhpSupportKo', 'PDO');
    $checksok = 0;
} else {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('PhpSupportOk', 'PDO') . '<br>';
}

$memrequiredorig = '128M';
$memrequired = 128 * 1024 * 1024;
$memmaxorig = ini_get('memory_limit');
$memmax = ini_get('memory_limit');
if ($memmaxorig != '') {
    preg_match('/([0-9]+)([a-zA-Z]*)/i', $memmax, $reg);
    if ($reg[2]) {
        if (strtoupper($reg[2]) == 'G') {
            $memmax = $reg[1] * 1024 * 1024 * 1024;
        }
        if (strtoupper($reg[2]) == 'M') {
            $memmax = $reg[1] * 1024 * 1024;
        }
        if (strtoupper($reg[2]) == 'K') {
            $memmax = $reg[1] * 1024;
        }
    }
    if ($memmax >= $memrequired || $memmax == -1) {
        print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
        print $langs->trans('PHPMemoryOK', $memmaxorig, $memrequiredorig) . '<br>';
    } else {
        print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>&nbsp;';
        print $langs->trans('PHPMemoryTooLow', $memmaxorig, $memrequiredorig) . '<br>';
        $checksok = 0;
    }
}

// 1. Check if config file exists
// 2. If not exists, try to copy the sample file
// 3. On fail of the above 2, try to create file
// 4. File is not readable and writable, abort.
$conffile = '../../conf/conf.php';

$confexists = 0;
$confreadable = 0;
$allowinstall = 0;

if (is_readable($conffile) && filesize($conffile) > 8) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #008000;"></i>&nbsp;';
    print $langs->trans('ConfFileExists') . '<br>';
    $confexists = 1;
    $confreadable = 1;
    $allowinstall = 1;
} elseif (@copy($conffile . '.example', $conffile)) {
    //success
    $confexists = 1;
    $confreadable = 1;
    $allowinstall = 1;
} else {
    // Create an empty file
    $fp = @fopen($conffile, 'w');
    if ($fp) {
        @fwrite($fp, '<?php');
        @fputs($fp, "\n");
        fclose($fp);
        $confexists = 1;
        $confreadable = 1;
        $allowinstall = 1;
    }
}

if ($confexists == 0) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>&nbsp;';
    print $langs->trans('ConfFileCannotCreate') . '<br>';
    $allowinstall = 0;
}
if ($confreadable == 0) {
    print '<i class="bi bi-exclamation-circle-fill" style="color: #ff0000;"></i>&nbsp;';
    print $langs->trans('ConfFileNotRewritable') . '<br>';
    $allowinstall = 0;
}

if ($checksok == 0 || $allowinstall == 0 || $confreadable == 0 || $confexists == 0) {
    exit();
} else {
    include_once $conffile;

    print '<br>';
    print '<a href="step1.php?checks=ok&allowinstall=yes"><button class="btn btn-primary btn-sm">' . $langs->trans('Continue') . '</button></a>';
}

print $twig->render(
    'install.footer.html.twig',
    [
        'langs'    => $langs,
        'main_url' => PM_INSTALL_MAIN_URL,
        'error'    => $errors,
        'message'  => $messages,
    ]
);
