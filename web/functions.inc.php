<?php /** @noinspection LongLine */

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: functions.inc.php
 *  Last Modified: 28.12.22 г., 2:49 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0
 * @version       1.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 **/

declare(strict_types = 1);

/**
 * \file        functions.inc.php
 */

include_once(MAIN_DOCUMENT_ROOT . '/includes/autoloader.inc.php');
include_once(MAIN_DOCUMENT_ROOT . '/core/lib/functions.lib.php');
include_once(MAIN_DOCUMENT_ROOT . '/core/class/translator.class.php');

// Initialize the session
session_start();

//Initiate user and fetch ID if logged in
$user = new user();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
	$user->fetch($_SESSION['id']);
	$theme = $user->theme ? : 'default';
	$language = $user->language ? : 'en_US';
}
$langs = new translator('');
if ($user->language) {
	$langs->setDefaultLang($user->language);
} else {
	$langs->setDefaultLang('auto');
}

$langs->loadLangs(['main']);

/**
 * Function to load global header
 *
 * @return void
 */
function pm_header()
{

	global $langs, $theme;

	print '<!DOCTYPE html>';

	print '<html http://www.w3.org/1999/xhtml lang="' . $langs->getDefaultLang() . '">' . "\n";

	print '<head>' . "\n" . '<title>' . MAIN_APPLICATION_TITLE . '</title>' . "\n";

	print '<meta charset="UTF-8">' . "\n";
	print '<meta name="robots" content="noindex,nofollow">' . "\n";
	print '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
	print '<meta name="author" content="blacktiehost.com">' . "\n";

	print '<link rel="shortcut icon" type="image/x-icon" href="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/favicon.png"/>' . "\n";

	print '<link type="text/css" rel="stylesheet" href="' . MAIN_URL_ROOT . '/theme/' . $theme . '/css/bootstrap.min.css">' . "\n";

	print '<link type="text/css" rel="stylesheet" href="' . MAIN_URL_ROOT . '/theme/default/css/bootstrap-grid.css">' . "\n";
	print '<link type="text/css" rel="stylesheet" href="' . MAIN_URL_ROOT . '/theme/default/css/bootstrap-utilities.css">' . "\n";
	print '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">' . "\n";

	print '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>' . "\n";

	print "</head>\n";
	print '<body class="d-flex vh-100 flex-column">' . "\n";
}

/**
 * Function to load main navbar
 *
 * @return void
 */
function pm_navbar()
{

	global $user, $theme, $langs, $error;

	$background1 = '';
	$background2 = '';
	$background = '';

	if ($theme == 'default') {
		$background1 = 'bg-body-secondary';
		$background2 = 'bg-body-tertiary';
	} elseif ($theme == 'dark') {
		$background1 = 'bg-dark';
		$background2 = 'bg-dark-subtle';
	}

	print '<nav class="navbar navbar-expand '.$background1.'">';
	print '<div class="container">';
	print '<a class="navbar-brand" href="' . MAIN_URL_ROOT . '">';
	print '<img src="'.MAIN_URL_ROOT.'/theme/' . $theme . '/img/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top me-2">';
	print MAIN_APPLICATION_TITLE . '</a>';
	print '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
	print '<ul class="navbar-nav me-auto mb-2 mb-lg-0">';
	print '<li class="nav-item">';
	print '<a class="nav-link" aria-current="page" href="' . MAIN_URL_ROOT . '">'. $langs->trans('Domains') .'</a>';
	print '</li>';
	print '<li class="nav-item">';
	print '<a class="nav-link" href="' . MAIN_URL_ROOT . '/records.php">'. $langs->trans('Records') .'</a>';
	print '</li>';
	print '<li class="nav-item">';
	print '<a class="nav-link" aria-current="page" href="' . MAIN_URL_ROOT . '/index.php?action=add_domain">'. $langs->trans('AddDomain') .'</a>';
	print '</li>';
	print '<li class="nav-item">';
	print '<a class="nav-link" aria-current="page" href="' . MAIN_URL_ROOT . '/records.php?action=add_record">'. $langs->trans('AddRecord') .'</a>';
	print '</li>';
	print '</ul>';

	if ($user->id > 0 && !$error) {
		print '<form class="d-flex" role="search" method="post">';
		print '<input type="hidden" name="action" value="search"/>';
		print '<input class="form-control me-2" name="search_string" type="text" placeholder="' . $langs->trans('Search') . '..." aria-label="Search">';
		print '<input class="btn btn-outline-success" type="submit" name="submit" value="' . $langs->trans('Search') . '"/>';
		print '</form>';
	}
	print '</div>';
	print '</div>';
	print '</nav>';

	if ($user->id > 0 && !$error) {
		print '<nav class="navbar navbar-expand ' . $background2 . '">';
		print '<div class="container">';
		print '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
		print '<div class="d-flex ms-auto">';
		if ($user->first_name || $user->last_name) {
			print '<span class="me-3">' . $langs->trans('Hi') . ' <b>' . $user->first_name . ' ' . $user->last_name . '</b></span>';
		} else {
			print '<span class="me-3">' . $langs->trans('Hi') . ' <b>' . $user->username . '</b></span>';
		}
		print '<a class="nav-link me-3" aria-current="page" href="profile.php"><i class="bi bi-person-fill"></i>&nbsp;' . $langs->trans('Profile') . '</a>';
		print '<a class="nav-link" aria-current="page" href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?action=logout"><i class="bi bi-box-arrow-right"></i>&nbsp;'.$langs->trans('Logout').'?</a>';
		print '<div>';
		print '<div>';
		print '<div>';
		print '</nav>';
	}
	if ($theme == 'default') {
		$background = 'bg-light';
	} elseif ($theme == 'dark') {
		$background = 'bg-dark-subtle';
	}
	print '<div class="flex-grow-1 '.$background.' ">';
}

/**
 * Global errors display block
 *
 * @return void
 */
function pm_message_block()
{

	global $error, $message;

	if ($error) {
		print '<div class="container text-center">';
		print '<div class="row">';
		print '<div class="col"></div>';
		print '<div class="col">';
		print '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
		print '<strong>' . $error . '</strong>';
		print '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
		print '</div>';
		print '</div>';
		print '</div>';
		print '</div>';
	}
	if ($message) {
		print '<div class="container text-center">';
		print '<div class="row">';
		print '<div class="col"></div>';
		print '<div class="col">';
		print '<div class="alert alert-success alert-dismissible fade show" role="alert">';
		print '<strong>' . $message . '</strong>';
		print '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
		print '</div>';
		print '</div>';
		print '</div>';
		print '</div>';
	}
}

/**
 * Global block to redirect on logout
 *
 * @return void
 */
function pm_logout_block()
{

	global $action;

	if ($action == 'logout') {
		$_SESSION = [];

		// Destroy the session.
		session_destroy();

		// Redirect to login page
		header('location: ' . MAIN_URL_ROOT . '/login.php');
		exit;
	}
}

/**
 * Function to load global footer
 *
 * @return void
 */
function pm_footer()
{
	global $langs, $theme;

	$background = '';
	$text_color = '';

	print '</div>';

	if ($theme == 'default') {
		$background = 'bg-light';
	} elseif ($theme == 'dark') {
		$background = 'bg-dark';
		$text_color = '#fff';
	}
	print '<footer class="text-center text-lg-start '.$background.' text-muted">';
	print '<div class="text-center p-4" style="color: '.$text_color.';">';
	print '&copy; 2020 - 2022 '.$langs->trans('AllRightsReserved').'. ';
	print '<a class="text-reset fw-bold" href="https://blacktiehost.com/">BlackTieHost.com</a>';
	print '</div>';
	print '</footer>';
	print '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>' . "\n";
	print "</body>\n";
	print "</html>\n";
}