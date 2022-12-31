<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: records.php
 *  Last Modified: 31.12.22 г., 2:19 ч.
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
 * \file        records.php
 * \ingroup     Password Manager
 * \brief        File to manage records for Password manager Domains
 */

declare(strict_types = 1);

namespace PasswordManager;

use Exception;

include_once('../includes/main.inc.php');

// Check if the user is logged in, if not then redirect him to login page
if (!isset($user->id) || $user->id < 1) {
	header('location: ' . PM_MAIN_URL_ROOT . '/login.php');
	exit;
}

$error = '';
$message = '';

/*
 * Initiate POST values
 */
$action = GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view';
$id = GETPOST('id', 'int');
$search_string = GETPOST('search_string', 'az09');
$fk_domain = GETPOST('fk_domain', 'int');
$type = GETPOST('type', 'int');
$url = GETPOST('url', 'az09');
$username = GETPOST('username', 'az09');
$password = GETPOST('password', 'alpha');
$error = GETPOST('error', 'alpha');
$message = GETPOST('message', 'alpha');

/*
 * Objects
 */
$records = new records($db);
$domains = new domains($db);

/*
 * Actions
 */
pm_logout_block();
if ($action == 'create') {
	$records->fk_domain = (int)$fk_domain;
	$records->fk_user = $user->id;
	if ($type == 1) {
		$records->is_db = true;
		$records->is_ftp = false;
		$records->is_site = false;
		$records->dbase_name = $url;
	} elseif ($type == 2) {
		$records->is_db = false;
		$records->is_ftp = false;
		$records->is_site = true;
		$records->url = $url;
	} elseif ($type == 3) {
		$records->is_db = false;
		$records->is_ftp = true;
		$records->is_site = false;
		$records->ftp_server = $url;
	}
	$records->username = $username;

	require_once(PM_MAIN_APP_ROOT . '/docs/secret.key');
	$password = openssl_encrypt($password, $ciphering, $encryption_key, $options, $encryption_iv);

	$records->pass_crypted = $password;
	$result = $records->create();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		print $result;
	}
}
if ($action == 'confirm_edit') {
	$records->id = (int)$id;
	if ($fk_domain) {
		$records->fk_domain = (int)$fk_domain;
	}
	if ($type == 1) {
		$records->is_db = true;
		$records->is_ftp = false;
		$records->is_site = false;
		$records->dbase_name = $url;
	} elseif ($type == 2) {
		$records->is_db = false;
		$records->is_ftp = false;
		$records->is_site = true;
		$records->url = $url;
	} elseif ($type == 3) {
		$records->is_db = false;
		$records->is_ftp = true;
		$records->is_site = false;
		$records->ftp_server = $url;
	}
	if ($username) {
		$records->username = $username;
	}
	if ($password) {
		$records->password = $password;
	}
	$result = $records->update();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		print $result;
	}
}
if ($action == 'delete') {
	$records->id = (int)$id;
	$result = $records->delete();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		print $result;
	}
}

/*
 * View
 */
$messageblock = $twig->render(
	'messageblock.html.twig',
	[
		'error'   => $error,
		'message' => $message,
	]
);

if ($action == 'view') {

	if ($fk_domain) {
		try {
			$res = $records->fetchAll(['fk_user' => $user->id, 'fk_domain' => $fk_domain]);
		}
		catch (Exception $e) {
			$error = $e->getMessage();
		}
	} else {
		try {
			$res = $records->fetchAll(['fk_user' => 1]);
		}
		catch (Exception $e) {
			$error = $e->getMessage();
		}
	}

	print $messageblock;
	print $twig->render(
		'records/view.table.head.html.twig',
		[
			'res'      => $res,
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
			'count'    => $langs->trans('NumRecords', count($res)),
			'domains'  => $domains,
			'twigext'  => $twig_ext,
		]
	);

	foreach ($res as $result) {
		require_once(PM_MAIN_APP_ROOT . '/docs/secret.key');
		$password = openssl_decrypt($result['pass_crypted'], $ciphering, $decryption_key, $options, $decryption_iv);
		print $twig->render(
			'records/view.table.content.html.twig',
			[
				'result'   => $result,
				'langs'    => $langs,
				'main_url' => PM_MAIN_URL_ROOT,
				'theme'    => $theme,
				'domains'  => $domains,
				'password' => $password,
			]
		);
	}

	print $twig->render(
		'records/view.table.footer.html.twig',
		[
			'res'      => $res,
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
			'domains'  => $domains,
			'twigext'  => $twig_ext,
		]
	);
} elseif ($action == 'add_record') {
	try {
		$res = $domains->fetchAll(['fk_user' => $user->id]);
	}
	catch (Exception $e) {
		$error = $e->getMessage();
	}
	print $twig->render(
		'records/add_table.html.twig',
		[
			'res'      => $res,
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
		]
	);
} elseif ($action == 'edit') {
	try {
		$res1 = $domains->fetchAll(['fk_user' => $user->id]);
		$res2 = $records->fetch($id);
	}
	catch (PDOException|Exception $e) {
		$error = $e->getMessage();
	}
	print $messageblock;
	print $twig->render(
		'records/edit_table.html.twig',
		[
			'res1'      => $res1,
			'res2'      => $res2,
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
		]
	);
} elseif ($action == 'search') {
	print $twig->render(
		'records/view.table.head.html.twig',
		[
			'res'      => $res,
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
			'count'    => $langs->trans('NumRecords', count($res)),
			'domains'  => $domains,
			'twigext'  => $twig_ext,
		]
	);

	try {
		$res = $records->fetchAll(['fk_user' => 1, 'dbase_name' => $search_string, 'ftp_server' => $search_string, 'url' => $search_string], 'OR');
	}
	catch (Exception $e) {
		$error = $e->getMessage();
	}

	print $messageblock;

	foreach ($res as $result) {
		require_once(PM_MAIN_APP_ROOT . '/docs/secret.key');
		$password = openssl_decrypt($result['pass_crypted'], $ciphering, $decryption_key, $options, $decryption_iv);
		print $twig->render(
			'records/view.table.content.html.twig',
			[
				'result'   => $result,
				'langs'    => $langs,
				'main_url' => PM_MAIN_URL_ROOT,
				'theme'    => $theme,
				'domains'  => $domains,
				'password' => $password,
			]
		);
	}

	print $twig->render(
		'records/view.table.footer.html.twig',
		[
			'res'      => $res,
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
			'domains'  => $domains,
			'twigext'  => $twig_ext,
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
		'langs' => $langs,
		'theme' => $theme,
		'background'=> $background,
	]
);
print $twig->render('javascripts.html.twig');
print $twig->render('endpage.html.twig');

