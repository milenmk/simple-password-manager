<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: step3.php
 *  Last Modified: 3.01.23 г., 10:45 ч.
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
 * \file        step3.php
 * \ingroup     Password Manager
 * \brief       Create admin user
 */

declare(strict_types=1);

$allow_continue = 0;

try {
    include_once('inc.php');
} catch (Exception $e) {
    $error = $e->getMessage();
    print 'File "inc.php" not found!';
    die();
}

$lockerror = '';
//Check for lock file
$lockfile = '../../docs/install.lock';
if (file_exists($lockfile)) {
    $lockerror = 1;
}

/*
 * Actions
 */
if ($_POST['action'] == 'create_admin') {
    //var_dump($_POST);

    $admin_user = strip_tags($_POST['admin_user']);
    $admin_pass = strip_tags($_POST['admin_pass']);
    $admin_user2 = htmlspecialchars($admin_user, ENT_QUOTES);
    $admin_pass2 = htmlspecialchars($admin_pass, ENT_QUOTES);

    $password = password_hash($admin_pass2, PASSWORD_DEFAULT);

    include_once('../../conf/conf.php');

    define('PM_MAIN_DB_PREFIX', $db_prefix);

    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;port=$port", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO ' . PM_MAIN_DB_PREFIX . 'users (username, password, language, theme, admin)';
    $sql .= ' VALUES(:username, :password, "en_US", "default", 1)';

    $query = $conn->prepare($sql);
    $query->bindValue(':username', $admin_user2);
    $query->bindValue(':password', $password);

    $res = $query->execute();

    if ($res) {
        //create lock file to prevent access to install files
        $filelock = '../../docs/install.lock';
        touch($filelock);

        header('Location: ../login.php');
        exit();
    } elseif ($conn->errorInfo() !== null) {
        $error = $conn->errorInfo();
    } else {
        $error = $langs->trans('CannotCreateAdmin');
    }
}

/*
 * View
 */

print $twig->render(
    'step3.body.html.twig',
    [
        'langs'        => $langs,
        'main_url'     => PM_INSTALL_MAIN_URL,
        'root_folder'  => PM_INSTALL_APP_ROOT_FOLDER,
        'lockerror'    => $lockerror,
        'installerror' => $installerror,
        'title'        => $langs->trans('CreateAdmin'),
        'db_error'     => $error,
    ]
);

if ($lockerror) {
    print $langs->trans('InstallLockfileError');
}

print $twig->render(
    'install.footer.html.twig',
    [
        'langs'    => $langs,
        'main_url' => PM_INSTALL_MAIN_URL,
        'error'    => $errors,
        'message'  => $messages,
    ]
);
