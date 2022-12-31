<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: profile.php
 *  Last Modified: 31.12.22 г., 11:09 ч.
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
 * \file        profile.php
 * \ingroup     Password Manager
 * \brief       User profile page
 */

declare(strict_types = 1);

namespace PasswordManager;

use Exeption;

include_once('../includes/main.inc.php');

// Check if the user is logged in, if not then redirect him to login page
if (!isset($user->id) || $user->id < 1) {
	header('location: ' . PM_MAIN_URL_ROOT . '/login.php');
	exit;
}

$error = '';
$message = '';

$langs->loadLangs(['errors']);

/*
 * Initiate POST values
 */
$action = GETPOST('action', 'alpha');
$id = GETPOST('id', 'int');
$first_name = GETPOST('first_name', 'alpha');
$last_name = GETPOST('last_name', 'alpha');
$username = GETPOST('email', 'az09');
$old_password = GETPOST('old_password', 'az09');
$new_password = GETPOST('new_password', 'az09');
$confirm_password = GETPOST('confirm_password', 'az09');
$user_theme = GETPOST('user_theme', 'alpha');
$user_language = GETPOST('user_language', 'alpha');

/*
 * Objects
 */
$user = new user($db);

$res = $user->fetch($_SESSION['id']);
$user->id = (int)$res['id'];
$user->first_name = $res['first_name'];
$user->last_name = $res['last_name'];
$user->username = $res['username'];
$user->theme = $res['theme'];
$user->language = $res['language'];

/*
 * Actions
 */
if ($action == 'update_user') {

	$user->first_name = $first_name;
	$user->last_name = $last_name;
	$user->username = $username;
	$user->theme = $user_theme;
	$user->language = $user_language;

	$result = $user->update($new_password);
	if ($result > 0) {
		$action = 'view';
		header('Location: profile.php');
	} else {
		$error = $user->error;
		$action = 'view';
	}
}
if ($action == 'change_password') {

	// Check if input fields are is empty
	if (empty(trim($old_password))) {
		$error = $langs->trans('PasswordEmpty');
	} else {
		$old_password = trim($old_password);
	}
	if (empty(trim($new_password))) {
		$error = $langs->trans('PasswordNewEmpty');
	} else {
		$new_password = trim($new_password);
	}
	if (empty(trim($confirm_password))) {
		$error = $langs->trans('PasswordNewConfirmEmpty');
	} else {
		$confirm_password = trim($confirm_password);
	}
	if ($new_password != $confirm_password) {
		$error = $langs->trans('PasswordsDidNotMatch');
	}

	if (!$error) {
		$result = $user->fetch($user->id, '', '', '', '', '', '', '', $old_password);
		if (!empty($result) && $result > 0) {
			$res = $user->update($new_password);

			if ($res > 0) {
				$message = $langs->trans('PassUpdateSuccess');
			} else {
				$error = $user->error;
			}
		}

	}
	$action = 'edit_password';
}

$message = $twig->render(
	'messageblock.html.twig',
	[
		'error'   => $error,
		'message' => $message,
	]
);

if ($action == 'view' || empty($action)) {

	print $message;

	$theme_array = [];
	$theme_folders = array_filter(glob(PM_MAIN_APP_ROOT . '/public/themes/*'), 'is_dir');
	foreach ($theme_folders as $folder) {
		$folder = substr(strrchr($folder, '/'), 1);
		$theme_array[] = $folder;
	}

	$lang_array = [];
	$lang_folders = array_filter(glob(PM_MAIN_APP_ROOT . '/langs/*'), 'is_dir');
	foreach ($lang_folders as $folder) {
		$folder = substr(strrchr($folder, '/'), 1);
		$lang_array[] = $folder;
	}

	print $twig->render(
		'user/profile.html.twig',
		[
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
			'user'     => $user,
			'theme_folders'  => $theme_array,
			'lang_folders'  => $lang_array,
		]
	);
} elseif ($action == 'edit_password') {
	print $message;
	print $twig->render(
		'user/edit_password.html.twig',
		[
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
		]
	);
}

if ($theme == 'default') {
	$background = 'bg-light';
} elseif ($theme == 'dark') {
	$background = 'bg-dark-subtle';
}
print $twig->render(
	'footer.html.twig',
	[
		'langs'      => $langs,
		'theme'      => $theme,
		'background' => $background,
	]
);

print $twig->render('javascripts.html.twig');
print $twig->render('endpage.html.twig');
