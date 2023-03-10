<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: index.php
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
 * \file        index.php
 * \ingroup     Password Manager
 * \brief       index file for Password Manager to manage Domains
 */

declare(strict_types=1);

use PasswordManager\Domains;

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
$label = GETPOST('label', 'az09');
$search_string = GETPOST('search_string', 'az09');

/*
 * Objects
 */
$domains = new Domains($db);

$title = $langs->trans('Domains');

/*
 * Actions
 */
//Action for logout
pm_logout_block();

//Action to create
if ($action == 'create') {
    $domains->label = $label;
    $domains->website = 0;
    $domains->ftp = 0;
    $domains->data_base = 0;
    $domains->fk_user = $user->id;
    $result = $domains->create();
    if ($result > 0) {
        $action = 'view';
    } else {
        $errors = $domains->error;
    }
}
//Action to edit
if ($action == 'edit') {
    $domains->fetch((int)$id);
    $domains->label = $label;
    $result = $domains->update();
    if ($result > 0) {
        $action = 'view';
    } else {
        $errors = $domains->error;
    }
}
//Action to delete
if ($action == 'delete') {
    $domains->id = (int)$id;
    $result = $domains->delete();
    if ($result > 0) {
        $action = 'view';
    } else {
        $errors = $domains->error;
    }
}

/*
 * View
 */

if ($action == 'add_domain') {
    print $twig->render(
        'index.add.html.twig',
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
} elseif ($action == 'edit_domain') {
    $res = $domains->fetchAll('rowid = :id AND fk_user = :fk_user', [':id' => $id, ':fk_user' => $user->id]);

    print $twig->render(
        'index.edit.html.twig',
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
} else {
    if ($action == 'search') {
        $res = $domains->fetchAll(
            'fk_user = :fk_user AND label LIKE :label',
            [':fk_user' => $user->id, ':label' => '%' . $search_string . '%']
        );
    } else {
        $res = $domains->fetchAll(
            'fk_user = :fk_user',
            [':fk_user' => $user->id]
        );
    }

    $count = $res > 1 ? count($res) : 0;

    print $twig->render(
        'index.view.html.twig',
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
            'count'     => $langs->trans('NumRecords', (string)$count),
        ]
    );
}
