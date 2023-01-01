<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: register.php
 *  Last Modified: 1.01.23 г., 20:56 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       2.1.1
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

use Exception;

$error = '';

try {
    include_once('../includes/main.inc.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    pm_syslog('Cannot load file vendor/autoload.php with error ' . $error, LOG_ERR);
    print 'File "includes/main.inc.php!"not found';
    die();
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($user->id) && $user->id > 0) {
    header('location: ' . PM_MAIN_URL_ROOT);
    exit;
}

/*
 * Objects
 */
$user = new User($db);

/*
 * Initiate POST values
 */
$action = GETPOST('action', 'alpha');
$first_name = GETPOST('first_name', 'alpha');
$last_name = GETPOST('last_name', 'alpha');
$username = GETPOST('email', 'az09');
$password = GETPOST('password', 'az09');
$confirm_password = GETPOST('confirm_password', 'az09');

/*
 * Actions
 */
if ($action == 'create') {
    //Validate firstname
    if ($first_name) {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($first_name))) {
            $_SESSION['PM_ERROR'] = 'FirstNameContentError';
            $error++;
        }
    }

    //Validate last name
    if ($last_name) {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($last_name))) {
            $_SESSION['PM_ERROR'] = 'LastNameContentError';
            $error++;
        }
    }

    // Validate password
    if (empty(trim($password))) {
        $_SESSION['PM_ERROR'] = 'PasswordEmpty';
        $error++;
    } elseif (strlen(trim($password)) < 6) {
        $_SESSION['PM_ERROR'] = 'PasswordLengthError';
        $error++;
    }

    // Validate confirm password
    if (empty(trim($confirm_password))) {
        $_SESSION['PM_ERROR'] = 'PasswordConfirmEmpty';
        $error++;
    } else {
        $confirm_password = trim($confirm_password);
        if (empty($password_err) && ($password != $confirm_password)) {
            $_SESSION['PM_ERROR'] = 'PasswordsDidNotMatch';
            $error++;
        }
    }

    if (empty(trim($username))) {
        $_SESSION['PM_ERROR'] = 'PleaseEnterUsername';
    } elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', trim($username))) {
        $_SESSION['PM_ERROR'] = 'UsernameContentError';
    }
    if (!$error) {
        $result = $user->check($username);

        if ($result > 0) {
            $_SESSION['PM_ERROR'] = 'UserNameTaken';
        } elseif (($result < 0 || empty($result))) {
            $usertmp = new User($db);
            $usertmp->first_name = $first_name;
            $usertmp->last_name = $last_name;
            $usertmp->username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            $res = $usertmp->create($param_password);

            if ($res > 0) {
                $_SESSION['PM_MESSAGE'] = 'UserCreated';

                $created = 'OK';
            } else {
                $_SESSION['PM_ERROR'] = 'GeneralError';
            }
        } else {
            $_SESSION['PM_ERROR'] = 'GeneralError';
        }
    }
}
/*
 * View
 */
print $twig->render(
    'register.html.twig',
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
if ($created == 'OK') {
    echo '<script>setTimeout(function(){ window.location.href= "' . PM_MAIN_URL_ROOT . '/login.php";}, 2000);</script>';
}

$db->close();
