<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: profile.php
 *  Last Modified: 19.01.23 г., 22:46 ч.
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
 * \file        profile.php
 * \ingroup     Password Manager
 * \brief       User profile page
 */

declare(strict_types=1);

$error = '';

try {
    include_once('../includes/main.inc.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    pm_syslog('Cannot load file includes/main.inc.php with error ' . $error, LOG_ERR);
    print 'File "includes/main.inc.php!"not found';
    die();
}

// Check if the user is logged in, if not then redirect him to login page
if (!isset($user->id) || $user->id < 1) {
    header('Location: ' . PM_MAIN_URL_ROOT . '/login.php');
    exit;
}

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

$title = $langs->trans('Profile');

/*
 * Actions
 */
if ($action == 'update_user') {
    if ($first_name) {
        $user->first_name = $first_name;
    } else {
        $user->first_name = '';
    }
    if ($last_name) {
        $user->last_name = $last_name;
    } else {
        $user->last_name = '';
    }
    $user->username = $username;
    $user->theme = $user_theme;
    $user->language = $user_language;

    $result = $user->update();

    if ($result < 1) {
        $_SESSION['PM_ERROR'] = 'ProfileUpdatedError';
        $error++;
    } else {
        $_SESSION['PM_MESSAGE'] = 'ProfileUpdated';
        header('Location: profile.php');
    }
}
if ($action == 'change_password') {
    // Check if input fields are is empty
    if (empty(trim($old_password))) {
        //$_SESSION['PM_ERROR'] = 'PasswordEmpty';
        $errors = $langs->trans('PasswordEmpty');
        $error++;
    } elseif (empty(trim($new_password))) {
        //$_SESSION['PM_ERROR'] = 'PasswordNewEmpty';
        $errors = $langs->trans('PasswordNewEmpty');
        $error++;
    } elseif (empty(trim($confirm_password))) {
        //$_SESSION['PM_ERROR'] = 'PasswordNewConfirmEmpty';
        $errors = $langs->trans('PasswordNewConfirmEmpty');
        $error++;
    } elseif ($new_password != $confirm_password) {
        //$_SESSION['PM_ERROR'] = 'PasswordsDidNotMatch';
        $errors = $langs->trans('PasswordsDidNotMatch');
        $error++;
    } else {
        $old_password = trim($old_password);
        $new_password = trim($new_password);
    }

    if (!$error) {
        $user->setPassword($old_password);
        $check = $user->checkPassword();

        if ($check == 1) {
            $user->setPassword($new_password);
            $user->updatePassword();
            $messages = $langs->trans('PassUpdateSuccess');
        } elseif ($check == -2) {
            $errors = $langs->trans('WrongPassword');
        } else {
            $errors = $langs->trans('PassUpdateError');
        }
    } else {
        print 'error';
    }
    $action = 'edit_password';
}

/*
 * View
 */
if ($action == 'edit_password') {
    print $twig->render(
        'user.edit_password.html.twig',
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
} else {
    //Action is 'view' or empty

    $theme_array = [];
    $theme_folders = array_filter(glob(PM_MAIN_APP_ROOT . '/public/themes/*'), 'is_dir');
    foreach ($theme_folders as $folder) {
        $folder = substr(strrchr($folder, '/'), 1);
        // Exclude admin theme, as it is tested only for admin dashboard
        if ($folder !== 'admin') {
            $theme_array[] = $folder;
        }
    }

    $lang_array = [];
    $lang_folders = array_filter(glob(PM_MAIN_APP_ROOT . '/langs/*'), 'is_dir');
    foreach ($lang_folders as $folder) {
        $folder = substr(strrchr($folder, '/'), 1);
        $lang_array[] = $folder;
    }

    print $twig->render(
        'user.profile.html.twig',
        [
            'langs'         => $langs,
            'theme'         => $theme,
            'app_title'     => PM_MAIN_APPLICATION_TITLE,
            'main_url'      => PM_MAIN_URL_ROOT,
            'css_array'     => $css_array,
            'js_array'      => $js_array,
            'user'          => $user,
            'title'         => $title,
            'error'         => $errors,
            'message'       => $messages,
            'theme_folders' => $theme_array,
            'lang_folders'  => $lang_array,
        ]
    );
}
