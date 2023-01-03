<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: index.php
 *  Last Modified: 3.01.23 г., 21:39 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.3.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        admin/index.php
 * \ingroup     Password Manager
 * \brief       Home page of admin interface
 */

declare(strict_types=1);

namespace PasswordManager;

use Exeption;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

try {
    include_once('../../includes/main.inc.php');
} catch (Exception $e) {
    print 'File "includes/main.inc.php!"not found' . $e->getMessage();
    die();
}

// Check if the user is logged in, if not then redirect him to login page
if (!isset($user->id) || $user->id < 1) {
    header('Location: ' . PM_MAIN_URL_ROOT . '/login.php');
    exit;
}

//Load language files for admin interface
$langs->loadLangs(['main', 'admin']);

if (!isset($user->admin) || !$user->admin) {
    print $langs->trans('AccessForbidden');
    exit;
}

$error = '';

/*
 * Initiate POST values
 */
$action = GETPOST('action', 'alpha');

/*
 * Objects
 */
$admin = new Admin($db);

/*
 * Load Twig environment
 */
// We need to reload Twig to apply theme
$loader = new FilesystemLoader(PM_MAIN_APP_ROOT . '/docs/templates/admin');
$twig = new Environment(
    $loader,
    [
        'debug' => true,
    ]
);
$twig->addExtension(new DebugExtension());

/*
 * Actions
 */
//Action for logout
pm_logout_block();

/*
 * View
 */

$domains_num = $admin->fetchNumRecords('domains');
$records_num = $admin->fetchNumRecords('records');
$users_num = $admin->fetchNumRecords('users');
$resultTopXbyRecords = $admin->topXbyRecords('records', (int)NUM_LIMIT_ADMIN_DASHBOARD);
$resultLastXUsers = $admin->lastXrecords(['first_name', 'last_name', 'username', 'created_at'], 'users', (int)NUM_LIMIT_ADMIN_DASHBOARD);

print $twig->render(
    'admin.dashboard.html.twig',
    [
        'langs'     => $langs,
        'app_title' => PM_MAIN_APPLICATION_TITLE,
        'main_url'  => PM_MAIN_URL_ROOT,
        'error'     => $errors,
        'message'   => $messages,
        'user_num'  => $users_num,
        'domains_num' => $domains_num,
        'records_num' => $records_num,
        'lastXUsers'  => $langs->trans('LastXUsers', NUM_LIMIT_ADMIN_DASHBOARD),
        'topXUsersByRecords' => $langs->trans('TopXUsersNumRecords', NUM_LIMIT_ADMIN_DASHBOARD),
        'resultTopXbyRecords' => $resultTopXbyRecords,
        'resultLastXUsers' => $resultLastXUsers,
    ]
);
