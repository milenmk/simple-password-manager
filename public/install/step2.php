<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: step2.php
 *  Last Modified: 4.01.23 г., 21:34 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.3.1
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        step2.php
 * \ingroup     Password Manager
 * \brief       Create database tables
 */

declare(strict_types=1);

$allow_continue = 0;

try {
    include_once('inc.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    print 'File "inc.php" not found!';
    die();
}

$lockerror = '';
//Check for lock file
$lockfile = '../../docs/install.lock';
if (file_exists($lockfile)) {
    $lockerror = 1;
}

/*
 * Actions
 */
if (!$lockerror) {
    $error = '';

    include_once('../../conf/conf.php');

    define('PM_MAIN_DB_PREFIX', $db_prefix);

    $main_db_character_set = str_replace('-', '', $main_db_character_set);

    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;port=$port", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requestnb = 0;

    /***************************************************************************************
     *
     * Create database tables from *.sql files
     * Must be done before *.key.sql files
     *
     ***************************************************************************************/

    $dir = 'tables/';
    $ok = 0;
    $handle = opendir($dir) or die($langs->trans('Cannot open dir'));
    $tablefound = 0;
    $tabledata = [];
    if (is_resource($handle)) {
        while (($file = readdir($handle)) !== false) {
            if (preg_match('/\.sql$/i', $file) && preg_match('/^pm_/i', $file) && !preg_match('/\.key\.sql$/i', $file)) {
                $tablefound++;
                $tabledata[] = $file;
            }
        }
        closedir($handle);
    }

    // Sort list of sql files on alphabetical order (load order is important)
    sort($tabledata);

    foreach ($tabledata as $file) {
        $name = substr($file, 0, strlen($file) - 4);
        $buffer = '';
        $fp = fopen($dir . $file, 'r');
        if ($fp) {
            while (!feof($fp)) {
                $buf = fgets($fp, 4096);
                if (substr($buf, 0, 2) <> '--') {
                    $buf = preg_replace('/--(.+)*/', '', $buf);
                    $buf = trim($buf, "\xEF\xBB\xBF");
                    $buffer .= $buf;
                }
            }
            fclose($fp);

            $buffer = trim($buffer);

            // Replace the prefix tables
            if (PM_MAIN_DB_PREFIX != 'pm_') {
                $buffer = preg_replace('/pm_/i', PM_MAIN_DB_PREFIX, $buffer);
            }

            $buffer = preg_replace('/table_collation/i', $main_db_collation, $buffer);
            $buffer = preg_replace('/table_character_set/i', $main_db_character_set, $buffer);

            $requestnb++;

            if (!$conn->inTransaction()) {
                $conn->beginTransaction();
            }

            try {
                $conn->exec($buffer);
            } catch (PDOException $e) {
                $error = $langs->trans('Cannot create database tables from file') . ' ' . $file . '. ' . $e->getMessage();
            }
        } else {
            $error = $langs->trans('Failed to open file') . ' ' . $file;
        }

        if ($tablefound) {
            if ($error == 0) {
                $ok = 1;
            }
        } else {
            $error = $langs->trans('Failed to find files to create database in directory!');
        }
    }
    $buffer = '';

    /***************************************************************************************
     *
     * Create database tables from *key.sql files
     * Must be done after *.sql files
     *
     ***************************************************************************************/
    $ok = 0;
    $okkeys = 0;
    $handle = opendir($dir) or die('Cannot open dir');
    $tablefound = 0;
    $tabledata = [];
    if (is_resource($handle)) {
        while (($file = readdir($handle)) !== false) {
            if (preg_match('/\.sql$/i', $file) && preg_match('/^pm_/i', $file) && preg_match('/\.key\.sql$/i', $file)) {
                $tablefound++;
                $tabledata[] = $file;
            }
        }
        closedir($handle);
    }

    // Sort list of sql files on alphabetical order (load order is important)
    sort($tabledata);
    foreach ($tabledata as $file) {
        $name = substr($file, 0, strlen($file) - 4);
        $buffer = '';
        $fp = fopen($dir . $file, 'r');
        if ($fp) {
            while (!feof($fp)) {
                $buf = fgets($fp, 4096);
                $buf = preg_replace('/--(.+)*/', '', $buf);
                $buf = trim($buf, "\xEF\xBB\xBF");
                $buffer .= $buf;
            }
            fclose($fp);

            $listesql = explode(';', $buffer);
            foreach ($listesql as $req) {
                $buffer = trim($req);
                if ($buffer) {
                    // Replace the prefix tables
                    if (PM_MAIN_DB_PREFIX != 'pm_') {
                        $buffer = preg_replace('/pm_/i', PM_MAIN_DB_PREFIX, $buffer);
                    }

                    $buffer = preg_replace('/table_collation/i', $main_db_collation, $buffer);
                    $buffer = preg_replace('/table_character_set/i', $main_db_character_set, $buffer);

                    $requestnb++;

                    if (!$conn->inTransaction()) {
                        $conn->beginTransaction();
                    }

                    try {
                        $conn->exec($buffer);
                    } catch (PDOException $e) {
                        $error = $langs->trans('Cannot create database tables from file') . ' ' . $file . '. ' . $e->getMessage();
                    }
                }
            }
        } else {
            $error = $langs->trans('Failed to find files to create database in directory!');
        }

        if ($tablefound) {
            if ($error == 0) {
                $ok = 1;
            }
        } else {
            $error = 'Failed to find files to create database in directory!';
        }
    }
}

if (!$error) {
    $con = null;

    $fileconf = '../../conf/conf.php';
    //Set conf file to read only
    if (isset($_SERVER['WINDIR'])) {
        // Host OS is Windows
        $fileconf = str_replace('/', '\\', $fileconf);
        unset($res);
        exec('attrib +R ' . escapeshellarg($fileconf), $res);
        $res = $res[0];
    } else {
        // Host OS is *nix
        $res = chmod($fileconf, 0644);
    }

    $allow_continue = 1;
}

/*
 * View
 */

print $twig->render(
    'step2.body.html.twig',
    [
        'langs'        => $langs,
        'main_url'     => PM_INSTALL_MAIN_URL,
        'root_folder'  => PM_INSTALL_APP_ROOT_FOLDER,
        'lockerror'    => $lockerror,
        'installerror' => $installerror,
        'title'        => $langs->trans('InstallingTables'),
        'db_error'     => $error,
    ]
);

if ($lockerror) {
    print $langs->trans('InstallLockfileError');
}

if ($allow_continue == 1) {
    header('Refresh: 3;url=step3.php');
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
