<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: main.inc.php
 *  Last Modified: 29.12.22 г., 23:33 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0
 * @version       2.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        main.inc.php
 * \ingroup     Password Manager
 * \brief       Dile to include main classes, functions, etc. before initiating the front end
 */

declare(strict_types = 1);

namespace PasswordManager;

use Exception;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

include_once('../vendor/autoload.php');

$config = new config();

if ($config < 1) {
	try {
		pm_syslog('ERROR: CANNOT CONNECT TO DATABASE SERVER', LOG_ERR);
	}
	catch (Exception $e) {
		print $e->getMessage();
		die();
	}
}

//Define some global constants from conf file
define('PM_MAIN_URL_ROOT', $config->main_url_root);
define('PM_MAIN_APP_ROOT', $config->main_app_root);
define('PM_MAIN_DOCUMENT_ROOT', PM_MAIN_APP_ROOT . '/docs');
define('PM_MAIN_APPLICATION_TITLE', $config->main_application_title);
define('PM_MAIN_DB_PREFIX', $config->dbprefix);

//Initiate translations
$langs = new translator('');

include_once('../core/lib/functions.lib.php');

$db = getPassManDbInstance($config->host, $config->dbuser, $config->dbpass, $config->dbname, $config->port);

unset($config->dbpass);

// Initialize the session
session_start();

//Initiate user and fetch ID if logged in
$user = new user($db);


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
	try {
		$res = $user->fetch($_SESSION['id']);
		$user->id = (int)$res['id'];
		$user->first_name = $res['first_name'];
		$user->last_name = $res['last_name'];
		$user->username = $res['username'];
		$user->theme = $res['theme'];
		$user->language = $res['language'];
	}
	catch (Exception $e) {
		$error = $e->getMessage();
		pm_syslog('Error trying to fetch user with ID ' . $_SESSION['id'] . ' with error ' . $error);
	}
}

if (isset($user->id) && $user->id > 0) {
	$theme = $user->theme;
	$language = $user->language;
} else {
	$theme = 'default';
}

//Load language
if ($language) {
	$langs->setDefaultLang($language);
} else {
	$langs->setDefaultLang('auto');
}
try {
	$langs->loadLangs(['main']);
}
catch (Exception $e) {
	print $e->getMessage();
}

//load twig
$loader = new FilesystemLoader(PM_MAIN_DOCUMENT_ROOT . '/templates');
$twig = new Environment(
	$loader, [
			   'debug' => true,
		   ]
);
$twig->addExtension(new DebugExtension());

try {
	print $twig->render(
		'header.html.twig',
		[
			'langs'     => $langs,
			'theme'     => $theme,
			'app_title' => PM_MAIN_APPLICATION_TITLE,
			'main_url'  => PM_MAIN_URL_ROOT,
		]
	);
}
catch (LoaderError|RuntimeError|SyntaxError $e) {
	print $e->getMessage();
}

try {
	if ($theme == 'default') {
		$background1 = 'bg-body-secondary';
		$background2 = 'bg-body-tertiary';
		$background3 = 'bg-light';
	} elseif ($theme == 'dark') {
		$background1 = 'bg-dark';
		$background2 = 'bg-dark-subtle';
		$background3 = 'bg-dark-subtle';
	}
	print $twig->render(
		'nav_menu.html.twig',
		[
			'langs'     => $langs,
			'theme'     => $theme,
			'app_title' => PM_MAIN_APPLICATION_TITLE,
			'main_url'  => PM_MAIN_URL_ROOT,
			'user'      => $user,
			'background1'=> $background1,
			'background2'=> $background2,
			'background2'=> $background3,
		]
	);
}
catch (LoaderError|RuntimeError|SyntaxError $e) {
	print $e->getMessage();
}

