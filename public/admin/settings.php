<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: settings.php
 *  Last Modified: 4.01.23 г., 20:56 ч.
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
 * \file        admin/settings.php
 * \ingroup     Password Manager
 * \brief       Admin page to manage global settings
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
$option_id = GETPOST('option_id', 'int');
$option_name = GETPOST('option_name', 'az09');
$option_value = GETPOST('option_value', 'az09');
$option_description = GETPOST('option_description', 'az09');

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

if ($action == 'update_option') {
    $result = $admin->update(
        [
            'name' => '' . $option_name,
            'value' => '' . $option_value,
            'description' => '' . $option_description
        ],
        'options',
        (int)$option_id
    );
}

/*
 * View
 */

$result = $admin->fetchAll(['name', 'value', 'description'], 'options');

print $twig->render(
    'admin.settings.html.twig',
    [
        'langs'       => $langs,
        'app_title'   => PM_MAIN_APPLICATION_TITLE,
        'main_url'    => PM_MAIN_URL_ROOT,
        'error'       => $errors,
        'message'     => $messages,
        'user_num'    => $users_num,
        'domains_num' => $domains_num,
        'records_num' => $records_num,
        'result'      => $result,
    ]
);
