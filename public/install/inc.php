<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: inc.php
 *  Last Modified: 4.01.23 г., 21:33 ч.
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
 * \file        inc.php
 * \ingroup     Password Manager
 * \brief       Include files required for installation
 */

declare(strict_types=1);

use PasswordManager\Translator;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

try {
    include_once('../../vendor/autoload.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    print $error . ' File "vendor/autoload.php"not found!';
    die();
}

// Initialize the session
session_start();

//Disable syslog
const PM_DISABLE_SYSLOG = 1;

//Load functions
try {
    include_once('../../core/lib/functions.lib.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    print $error . ' File "core/lib/functions.lib.php" not found!';
    die();
}

//Get url path for install purposes
$app_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['CONTEXT_PREFIX'];
define('PM_INSTALL_MAIN_URL', $app_url);
define('PM_INSTALL_APP_ROOT_FOLDER', dirname(__DIR__, 2));

//Initiate translations
$langs = new Translator(PM_INSTALL_APP_ROOT_FOLDER);

//Initiate language
$langs->setDefaultLang('auto');

//Load language
$langs->loadLangs(['main', 'errors', 'install']);

$messages = $_SESSION['PM_INSTALL_MESSAGE'] ? $langs->trans('' . $_SESSION['PM_INSTALL_MESSAGE']) : '';
$errors = $_SESSION['PM_INSTALL_ERROR'] ? $langs->trans('' . $_SESSION['PM_INSTALL_ERROR']) : '';

/*
 * Load Twig environment
 */
$loader = new FilesystemLoader('templates');
$twig = new Environment(
    $loader,
    [
        'debug' => true,
    ]
);
$twig->addExtension(new DebugExtension());
