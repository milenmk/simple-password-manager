<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: profile.php
 *  Last Modified: 28.12.22 г., 17:15 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0
 *  @version       1.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 **/

declare(strict_types = 1);

/**
 * \file        profile.php
 */

//Include main files
include_once('main.inc.php');

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
	header('location: ' . MAIN_URL_ROOT . '/login.php');
	exit;
}

global $user;

$error = '';

//Initiate POSt parameters
$theme = $user->theme ? : 'default';
$action = GETPOST('action', 'alpha');
$id = GETPOST('id', 'int');

//View
pm_header();

pm_navbar();

pm_footer();

$conn = null;