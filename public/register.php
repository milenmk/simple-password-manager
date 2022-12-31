<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: register.php
 *  Last Modified: 31.12.22 г., 18:16 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       2.1.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        register.php
 * \ingroup     Password Manager
 * \brief       Registration page
 */

declare(strict_types = 1);

namespace PasswordManager;

include_once('../includes/main.inc.php');

$error = '';
$message = '';

$langs->loadLangs(['errors']);

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($user->id) && $user->id > 0) {
	echo '<script>setTimeout(function(){ window.location.href= "' . PM_MAIN_URL_ROOT . '";});</script>';
	exit;
}

/*
 * Objects
 */
$user = new user($db);

/*
 * Initiate POST values
 */
$theme = GETPOST('theme', 'alpha') ? GETPOST('theme', 'alpha') : 'default';
$action = GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view';
$error = GETPOST('error', 'alpha');
$message = GETPOST('message', 'alpha');
$first_name = GETPOST('first_name', 'alpha');
$last_name = GETPOST('last_name', 'alpha');
$username = GETPOST('email', 'az09');
$password = GETPOST('password', 'az09');
$confirm_password = GETPOST('confirm_password', 'az09');

/*
 * Actions
 */
if ($action == 'create_user') {

	//Validate firstname
	if ($first_name) {
		if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($first_name))) {
			$error = $langs->trans('FirstNameContentError');
		}
	}

	//Validate last name
	if ($last_name) {
		if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($last_name))) {
			$error = $langs->trans('LastNameContentError');
		}
	}

	// Validate password
	if (empty(trim($password))) {
		$error = $langs->trans('PasswordEmpty');
	} elseif (strlen(trim($password)) < 6) {
		$error = $langs->trans('PasswordLengthError');
	}

	// Validate confirm password
	if (empty(trim($confirm_password))) {
		$error = $langs->trans('PasswordConfirmEmpty');
	} else {
		$confirm_password = trim($confirm_password);
		if (empty($password_err) && ($password != $confirm_password)) {
			$error = $langs->trans('PasswordsDidNotMatch');
		}
	}

	if (empty(trim($username))) {
		$error = $langs->trans('PleaseEnterUsername');
	} elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', trim($username))) {
		$error = $langs->trans('UsernameContentError');
	}
	if (!$error) {
		$result = $user->fetch('', ['username' => $username]);

		if ($result['id'] > 0) {
			$error = $langs->trans('UserNameTaken');
		} elseif (($result['id'] < 0 || empty($result['id'])) && empty($error)) {
			$usertmp = new user($db);
			$usertmp->first_name = $first_name;
			$usertmp->last_name = $last_name;
			$usertmp->username = $username;
			$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

			$res = $usertmp->create($param_password);

			if ($res > 0) {
				$message = $langs->trans('UserCreated');

				$created = 'OK';
			} else {
				$error = $langs->trans('GeneralError');
			}
		} else {
			$error = $langs->trans('GeneralError');
		}
	}
}

print $twig->render(
	'messageblock.html.twig',
	[
		'error'   => $error,
		'message' => $message,
	]
);

print $twig->render(
	'user/register.html.twig',
	[
		'langs'    => $langs,
		'main_url' => PM_MAIN_URL_ROOT,
		'theme'    => $theme,
	]
);

print $twig->render(
	'footer.html.twig',
	[
		'langs' => $langs,
		'theme' => $theme,
	]
);

if ($theme != 'default') {
	$js_path = PM_MAIN_APP_ROOT . '/public/themes/' . $theme . '/js/';

	if (is_dir($js_path)) {
		$js_array = [];
		foreach (array_filter(glob($js_path . '*.js'), 'is_file') as $file) {
			$js_array[] = str_replace($js_path, '', $file);
		}
	}
}
print $twig->render(
	'javascripts.html.twig',
	[
		'theme'    => $theme,
		'main_url' => PM_MAIN_URL_ROOT,
		'js_array' => $js_array,
	]
);

print $twig->render('endpage.html.twig');

if ($created == 'OK') {
	echo '<script>setTimeout(function(){ window.location.href= "' . PM_MAIN_URL_ROOT . '/login.php";}, 2000);</script>';
}