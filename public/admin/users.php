<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: users.php
 *  Last Modified: 3.01.23 г., 19:46 ч.
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
 * \file        users.php
 * \ingroup     Password Manager
 * \brief       Admin page to manage users
 */

declare(strict_types=1);

use PasswordManager\Admin;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

try {
    include_once('../../includes/main.inc.php');
} catch (Exception $e) {
    print 'File "includes/main.inc.php!"not found' . $e->getMessage();
    die();
}

/*
// Check if the user is logged in, if not then redirect him to login page
if (!isset($user->id) || $user->id < 1) {
    header('Location: ' . PM_MAIN_URL_ROOT . '/login.php');
    exit;
}
*/

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
$resultLastXUsers = $admin->lastXrecords(['first_name', 'last_name', 'username', 'created_at'], 'users');

print $twig->render(
    'admin.users.html.twig',
    [
        'langs'     => $langs,
        'app_title' => PM_MAIN_APPLICATION_TITLE,
        'main_url'  => PM_MAIN_URL_ROOT,
        'error'     => $errors,
        'message'   => $messages,
        'user_num'  => $users_num,
        'domains_num' => $domains_num,
        'records_num' => $records_num,
        'lastXUsers'  => $langs->trans('LastXUsers'),
        'resultLastXUsers' => $resultLastXUsers,
    ]
);