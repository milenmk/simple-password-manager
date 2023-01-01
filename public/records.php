<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: records.php
 *  Last Modified: 31.12.22 г., 20:53 ч.
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
 * \file        records.php
 * \ingroup     Password Manager
 * \brief        File to manage records for Password manager Domains
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

// Check if the user is logged in, if not then redirect him to login page
if (!isset($user->id) || $user->id < 1) {
    header('Location: '.PM_MAIN_URL_ROOT.'/login.php');
    exit;
}

/*
 * Initiate POST values
 */
$action = GETPOST('action', 'alpha');
$id = GETPOST('id', 'int');
$search_string = GETPOST('search_string', 'az09');
$fk_domain = GETPOST('fk_domain', 'int');
$type = GETPOST('type', 'int');
$url = GETPOST('url', 'az09');
$username = GETPOST('username', 'az09');
$password = GETPOST('password', 'alpha');

/*
 * Objects
 */
$records = new Records($db);
$domains = new Domains($db);

$title = $langs->trans('Records');

/*
 * Actions
 */
//Action for logout
pm_logout_block();

//Action to create
if ($action == 'create') {
    $records->fk_domain = (int)$fk_domain;
    $records->fk_user = $user->id;
    $records->type = (int)$type;
    $records->url = $url;
    $records->username = $username;

    require_once(PM_MAIN_APP_ROOT . '/docs/secret.key');
    $password = openssl_encrypt($password, $ciphering, $encryption_key, $options, $encryption_iv);
    $records->pass_crypted = $password;

    $result = $records->create();

    if ((isset($db->error) && $db->error) || $result < 1) {
        $errors = $db->error;
    } else {
        header('Location: ' . PM_MAIN_URL_ROOT . '/records.php');
    }
}
//Action to edit
if ($action == 'edit') {
    $records->id = (int)$id;
    if ($fk_domain) {
        $records->fk_domain = (int)$fk_domain;
    }
    $records->type = (int)$type;
    $records->url = $url;
    if ($username) {
        $records->username = $username;
    }
    if ($password) {
        require_once(PM_MAIN_APP_ROOT . '/docs/secret.key');
        $password = openssl_encrypt($password, $ciphering, $encryption_key, $options, $encryption_iv);

        $records->pass_crypted = $password;
    }
    $result = $records->update();
    if ($result > 0) {
        header('Location: '.PM_MAIN_URL_ROOT.'/records.php');
    }
}
//Action to delete
if ($action == 'delete') {
    $records->id = (int)$id;
    $result = $records->delete();
    if ($result < 0) {
        print $result;
    }
}

/*
 * View
 */
if ($action == 'add_record') {
    $res = $domains->fetchAll(['fk_user' => $user->id]);
    print $twig->render(
        'records.add.html.twig',
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
            'res'       => $res,
        ]
    );
} elseif ($action == 'edit_record') {
    $res1 = $domains->fetchAll(['fk_user' => $user->id]);
    $res2 = $records->fetch($id);
    print $twig->render(
        'records.edit.html.twig',
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
            'res1'     => $res1,
            'res2'     => $res2,
        ]
    );
} else {
    if ($action == 'search') {
        $res = $records->fetchAll(
            [
                'fk_user'    => $user->id,
                'dbase_name' => $search_string,
                'ftp_server' => $search_string,
                'url'        => $search_string,
            ],
            'OR'
        );
    } elseif ($fk_domain) {
        $res = $records->fetchAll(['fk_user' => $user->id, 'fk_domain' => $fk_domain]);
    } else {
        $res = $records->fetchAll(['fk_user' => $user->id]);
    }

    if (empty($res) || $res < 1) {
        $count = $langs->trans('NumRecords', '0');
    } else {
        $count = $langs->trans('NumRecords', count($res));
    }

    print $twig->render(
        'records.view.html.twig',
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
            'count'     => $count,
            'res'       => $res,
        ]
    );
}

$db->close();
