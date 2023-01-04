<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: login.php
 *  Last Modified: 4.01.23 г., 21:15 ч.
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
 * \file        login.php
 * \ingroup     Password Manager
 * \brief       Login page
 */

declare(strict_types=1);

use PasswordManager\User;

$error = '';

try {
    include_once('../includes/main.inc.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    pm_syslog('Cannot load file includes/main.inc.php with error ' . $error, LOG_ERR);
    print 'File "includes/main.inc.php!"not found';
    die();
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($user->id) && $user->id > 0) {
    header('location: ' . PM_MAIN_URL_ROOT);
    exit;
}

/*
 * Initiate POST values
 */
$action = GETPOST('action', 'alpha');
$username = GETPOST('email', 'az09');
$password = GETPOST('password', 'az09');

/*
 * Objects
 */
$user = new User($db);

/*
 * Actions
 */
if ($action == 'login_user') {
    // Check if username is empty
    if (empty(trim($username))) {
        $errors = $langs->trans('PleaseEnterUsername');
        $error++;
    } elseif (empty(trim($password))) {
        $errors = $langs->trans('PleaseEnterPassword');
        $error++;
    } else {
        $username = trim($username);
        $password = trim($password);
    }

    if (empty($error)) {
        $result = $user->check($username, 1);

        if ($result < 1 || empty($result)) {
            $errors = $langs->trans('InvalidNameOrPassword');
            $error++;
        }

        if (!$error && password_verify($password, $result['password'])) {
            // Password is correct, so start a new session
            $user->id = (int)$result['id'];
            session_start();

            // Store data in session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user->id;
            $_SESSION['username'] = $username;

            // Redirect user to home page
            header('location: ' . PM_MAIN_URL_ROOT);
            exit;
        } else {
            // Username doesn't exist, display a generic error message
            $errors = $langs->trans('InvalidNameOrPassword');
        }
    }
}

/*
 * View
 */
print $twig->render(
    'login.html.twig',
    [
        'langs'     => $langs,
        'theme'     => $theme,
        'app_title' => PM_MAIN_APPLICATION_TITLE,
        'main_url'  => PM_MAIN_URL_ROOT,
        'css_array' => $css_array,
        'js_array'  => $js_array,
        'user'      => $user,
        'title'     => $title,
        'error'     => $errors,
        'message'   => $messages,
    ]
);
