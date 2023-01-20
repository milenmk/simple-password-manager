<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: main.inc.php
 *  Last Modified: 20.01.23 г., 8:21 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       3.0.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        main.inc.php
 * \ingroup     Password Manager
 * \brief       Dile to include main classes, functions, etc. before initiating the front end
 */

declare(strict_types=1);

use PasswordManager\PassManDb;
use PasswordManager\Translator;
use PasswordManager\User;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

// We have to use silence operators here
// Otherwise first include will trow errors when accessing from sub-folders
@include_once('../vendor/autoload.php');
@include_once('../../vendor/autoload.php');

//Load the database handler
$db = new PassManDb();

const PM_MAIN_DOCUMENT_ROOT = PM_MAIN_APP_ROOT . '/docs';

//Initiate translations
$langs = new Translator('');

//Load functions
try {
    include_once(PM_MAIN_APP_ROOT . '/core/lib/functions.lib.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    if (empty(DISABLE_SYSLOG)) {
        pm_syslog('Cannot load file vendor/autoload.php with error ' . $error, LOG_ERR);
    }
    print 'File "core/lib/functions.lib.php" not found!';
    die();
}

// Initialize the session
session_start();

//Initiate user and fetch ID if logged in
$user = new User($db);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    try {
        $user->fetch($_SESSION['id']);
    } catch (Exception $e) {
        $error = $e->getMessage();
        if (empty(DISABLE_SYSLOG)) {
            pm_syslog('Error trying to fetch user with ID ' . $_SESSION['id'] . ' with error ' . $error, LOG_ERR);
        }
    }
}

//Define language and theme
$theme = $user->theme ?? 'default';
if (isset($user->language)) {
    $langs->setDefaultLang($user->language);
} else {
    $langs->setDefaultLang('auto');
}

//Load language
$langs->loadLangs(['main', 'errors']);

$messages = $_SESSION['PM_MESSAGE'] ? $langs->trans('' . $_SESSION['PM_MESSAGE']) : '';
$errors = $_SESSION['PM_ERROR'] ? $langs->trans('' . $_SESSION['PM_ERROR']) : '';

//Define css and .js files array for loading for themes different from default
if ($theme != 'default') {
    $css_path = PM_MAIN_APP_ROOT . '/public/themes/' . $theme . '/css/';

    if (is_dir($css_path)) {
        $css_array = [];
        foreach (array_filter(glob($css_path . '*.css'), 'is_file') as $file) {
            $css_array[] = str_replace($css_path, '', $file);
        }
    }
}

if ($theme != 'default') {
    $js_path = PM_MAIN_APP_ROOT . '/public/themes/' . $theme . '/js/';

    if (is_dir($js_path)) {
        $js_array = [];
        foreach (array_filter(glob($js_path . '*.js'), 'is_file') as $file) {
            $js_array[] = str_replace($js_path, '', $file);
        }
    }
}

/*
 * Load Twig environment
 */
$loader = new FilesystemLoader(PM_MAIN_APP_ROOT . '/docs/templates/' . $theme);
$twig = new Environment(
    $loader,
    [
        'debug' => true,
    ]
);
$twig->addExtension(new DebugExtension());

$open_ssl = new TwigFunction(
    'openssl',
    function ($password) {

        try {
            require(PM_MAIN_APP_ROOT . '/docs/secret.key');
        } catch (Exception $e) {
            $error = $e->getMessage();
            print $error . ': Cannot load file "docs/secret.key"!';
            die();
        }

        return openssl_decrypt($password, $ciphering, $decryption_key, $options, $decryption_iv);
    }
);
$twig->addFunction($open_ssl);

$unset = new TwigFunction(
    'unset',
    function ($var) {

        unset($_SESSION[$var]);
    }
);
$twig->addFunction($unset);
