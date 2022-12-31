<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: login.php
 *  Last Modified: 31.12.22 г., 6:33 ч.
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
 * \file        login.php
 * \ingroup     Password Manager
 * \brief       Login page
 */

declare(strict_types = 1);

namespace PasswordManager;

include_once('../includes/main.inc.php');

$error = '';
$message = '';

$langs->loadLangs(['errors']);

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($user->id) && $user->id > 0) {
	header('location: ' . MAIN_URL_ROOT);
	exit;
}

/*
 * Initiate POST values
 */
$theme = GETPOST('theme', 'alpha') ? GETPOST('theme', 'alpha') : 'default';
$action = GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view';
$error = GETPOST('error', 'alpha');
$message = GETPOST('message', 'alpha');
$username = GETPOST('email', 'az09');
$password = GETPOST('password', 'az09');

/*
 * Objects
 */
$user = new user($db);

/*
 * Actions
 */
if ($action == 'login_user') {

	// Check if username is empty
	if (empty(trim($username))) {
		$error = $langs->trans('PleaseEnterUsername');
	} else {
		$username = trim($username);
	}

	// Check if password is empty
	if (empty(trim($password))) {
		$error = $langs->trans('PleaseEnterPassword');
	} else {
		$password = trim($password);
	}

	if (empty($error)) {
		$result = $user->fetch('', ['username' => $username], '', '', '', '', '', '', $password);

		if ($result > 0) {
			// Password is correct, so start a new session
			$user->id = (int)$result;
			session_start();

			// Store data in session variables
			$_SESSION['loggedin'] = true;
			$_SESSION['id'] = $user->id;
			$_SESSION['username'] = $username;

			// Redirect user to welcome page
			header('location: ' . PM_MAIN_URL_ROOT);
		} else {
			// Username doesn't exist, display a generic error message
			$error = $langs->trans('InvalidNameOrPassword');
		}
	}
}

/*
 * View
 */
print $twig->render(
	'messageblock.html.twig',
	[
		'error'   => $error,
		'message' => $message,
	]
);

print $twig->render(
	'user/login.html.twig',
	[
		'langs'    => $langs,
		'main_url' => PM_MAIN_URL_ROOT,
		'theme'    => $theme,
	]
);

if ($theme == 'default') {
	$background = 'bg-light';
} elseif ($theme == 'dark') {
	$background = 'bg-dark-subtle';
}
print $twig->render(
	'footer.html.twig',
	[
		'langs' => $langs,
		'theme' => $theme,
		'background'=> $background,
	]
);

print $twig->render('javascripts.html.twig');
print $twig->render('endpage.html.twig');
