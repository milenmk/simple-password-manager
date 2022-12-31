<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: index.php
 *  Last Modified: 29.12.22 г., 20:40 ч.
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
 * \file        index.php
 * \ingroup     Password Manager
 * \brief       index file for Password Manager to manage Domains
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
$label = GETPOST('label', 'az09');
$search_string = GETPOST('search_string', 'az09');
$error = GETPOST('error', 'alpha');
$message = GETPOST('message', 'alpha');

/*
 * Objects
 */
$domains = new domains($db);

/*
 * Actions
 */
pm_logout_block();
if ($action == 'create') {
	$domains->label = $label;
	$domains->fk_user = 1;
	$result = $domains->create();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		$error = $domains->error;
	}
}
if ($action == 'confirm_edit') {
	$domains->id = (int)$id;
	$domains->label = $label;
	$result = $domains->update(['label']);
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		$error = $domains->error;
	}
}
if ($action == 'delete') {
	$domains->id = (int)$id;
	$result = $domains->delete();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		$error = $domains->error;
	}
}
if ($action == 'view_records') {
	header('Location:' . PM_MAIN_URL_ROOT . '/records.php?action=view&fk_domain=' . $id);
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
	try {
		$res = $domains->fetchAll(['fk_user' => $user->id]);
	}
	catch (PDOException|Exception $e) {
		$error = $e->getMessage();
	}
	print $messageblock;
	print $twig->render(
		'index/table.html.twig',
		[
			'res'      => $res,
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
			'count'    => $langs->trans('NumRecords', count($res)),
		]
	);
} elseif ($action == 'add_domain') {
	print $twig->render(
		'index/add_table.html.twig',
		[
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
		]
	);
} elseif ($action == 'edit') {
	try {
		$res = $domains->fetchAll(['rowid' => $id, 'fk_user' => $user->id]);
	}
	catch (PDOException|Exception $e) {
		$error = $e->getMessage();
	}
	print $messageblock;
	print $twig->render(
		'index/edit_table.html.twig',
		[
			'res'      => $res,
			'langs'    => $langs,
			'main_url' => PM_MAIN_URL_ROOT,
			'theme'    => $theme,
		]
	);
} elseif ($action == 'search') {
	try {
		$res = $domains->fetchAll(['fk_user' => $user->id, 'label' => $search_string]);
	}
	catch (PDOException|Exception $e) {
		$error = $e->getMessage();
	}
	print $messageblock;
	print $twig->render(
		'index/table.html.twig',
		[
			'res'      => $res,
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
		'langs' => $langs,
		'theme' => $theme,
		'background'=> $background,
	]
);

print $twig->render('javascripts.html.twig');
print $twig->render('endpage.html.twig');