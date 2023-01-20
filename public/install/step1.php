<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: step1.php
 *  Last Modified: 19.01.23 г., 22:46 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       3.0.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        step1.php
 * \ingroup     Password Manager
 * \brief       Configure application URL and database connection and then check for errors
 *              If no errors, create database and database user if they do not exist
 *              Write info on the config file
 */

declare(strict_types = 1);

use PasswordManager\PassManDb;

try {
    include_once('inc.php');
}
catch (Exception $e) {
    $error = $e->getMessage();
    print 'File "inc.php" not found!';
    die();
}

//Check for lock file
$lockfile = '../../docs/install.lock';
if (file_exists($lockfile)) {
    $lockerror = 1;
}

//Check if install is permitted. No direct access to this page is allowed
$url_query = $_SERVER['QUERY_STRING'];
parse_str($url_query, $params);
if (strcmp($params['checks'], 'ok') !== 0 || strcmp($params['allowinstall'], 'yes') !== 0) {
    $installerror = 1;
}

/*
 * Actions
 */

if ($_GET['action'] == 'check_connection' || $_POST['action'] == 'check_connection') {
    //var_dump($_POST);

    $error = 0;
    $dberror = '';

    $main_url_root = $_POST['main_url_root'];
    $main_app_root = $_POST['main_app_root'];
    $main_document_root = $_POST['main_document_root'];
    $db_host = $_POST['db_host'];
    $db_port = $_POST['db_port'];
    $db_prefix = $_POST['db_prefix'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_character_set = $_POST['db_character_set'];
    $db_collation = $_POST['db_collation'];
    $application_title = $_POST['application_title'];
    $create_database = $_POST['create_database'];
    $root_db_user = $_POST['root_db_user'];
    $root_db_pass = $_POST['root_db_pass'];

    if (strlen($db_prefix) > 5) {
        $error = 'PrefixError';
    }

    //If no error, try to connect to database
    if (!$error) {
        //Try to connect to server without database name set
        $conn = new PassManDb();

        // If connection error, show it
        if ($conn->error) {
            $dberror = $conn->error;
        }

        // If no error, user exists try connecting to database with database name set
        if (!$db->error) {
            //$res = $conn->selectDb($db_host, $db_user, $db_pass, $db_name, $db_character_set, $db_collation, (int)$db_port);
            $conn->db = new PDO(
                'mysql:host=' . $db_host . ';
                dbname=' . $db_name . ';
                port=' . $db_port,
                $db_user,
                $db_pass
            );
        }

        // If result is < 1, that means that the table is not existing OR the user doesn't have rights to access it.
        if ($res < 1 && $create_database == 1) {
            //Try connection with root user if specified
            //$res2 = $conn->selectDb($db_host, $root_db_user, $root_db_pass, '', $db_character_set, $db_collation, (int)$db_port);
            $conn->db = new PDO(
                'mysql:host=' . $db_host . ';
                dbname=' . $db_name . ';
                port=' . $db_port,
                $root_db_user,
                $root_db_pass
            );
            if ($res2 < 1) {
                $dberror = $conn->error;
            } else {
                if (!$conn->db->inTransaction()) {
                    $conn->db->beginTransaction();
                }

                $new_db_name = strip_tags($db_name);
                $new_db_character_set = strip_tags($db_character_set);
                $new_db_collation = strip_tags($db_collation);
                $new_db_user = strip_tags($db_user);
                $new_db_pass = strip_tags($db_pass);

                $new_db_name2 = htmlspecialchars($new_db_name, ENT_QUOTES);
                $new_db_character_set2 = htmlspecialchars($new_db_character_set, ENT_QUOTES);
                $new_db_collation2 = htmlspecialchars($new_db_collation, ENT_QUOTES);
                $new_db_user2 = htmlspecialchars($new_db_user, ENT_QUOTES);
                $new_db_pass2 = htmlspecialchars($new_db_pass, ENT_QUOTES);

                //Create the database and the user if they do not exist
                $conn->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $conn->db->exec(
                    "CREATE DATABASE IF NOT EXISTS $new_db_name2 
                    DEFAULT CHARACTER SET $new_db_character_set2 COLLATE $new_db_collation2;
                CREATE USER IF NOT EXISTS $new_db_user2@'localhost' IDENTIFIED BY '$new_db_pass2';
                GRANT ALL ON $new_db_name2.* TO $new_db_user2@'localhost';
                FLUSH PRIVILEGES;"
                );
            }
        } elseif ($res < 1 && empty($create_database)) {
            $dberror = $conn->error . '. ' . $langs->trans('ConnError1');
        }

        //No errors, database is present, user has rights.
        // Write data to config file and continue.
        if (!$db->error) {
            //Root user can connect. Write data to config file and continue.
            $conffile = '../../conf/conf.php';
            $new_file = fopen($conffile, 'w');

            fputs($new_file, '<?php' . "\n");
            fputs($new_file, "\n");
            fputs($new_file, 'declare(strict_types = 1);' . "\n");
            fputs($new_file, "\n");
            fputs($new_file, '/**' . "\n");
            fputs($new_file, ' * \file        conf/conf.php' . "\n");
            fputs($new_file, ' */' . "\n");
            fputs($new_file, "\n");

            fputs($new_file, '$main_url_root=\'' . $main_url_root . '\';');
            fputs($new_file, "\n");
            fputs($new_file, '$main_app_root=\'' . $main_app_root . '\';');
            fputs($new_file, "\n");
            fputs($new_file, '$main_document_root=\'' . $main_document_root . '\';');
            fputs($new_file, "\n");

            fputs($new_file, '$db_host=\'' . $db_host . '\';');
            fputs($new_file, "\n");

            fputs($new_file, '$db_port=\'' . $db_port . '\';');
            fputs($new_file, "\n");

            fputs($new_file, '$db_name=\'' . $db_name . '\';');
            fputs($new_file, "\n");

            fputs($new_file, '$db_prefix=\'' . $db_prefix . '\';');
            fputs($new_file, "\n");

            fputs($new_file, '$db_user=\'' . $db_user . '\';');
            fputs($new_file, "\n");
            fputs($new_file, '$db_pass=\'' . $db_pass . '\';');
            fputs($new_file, "\n");

            fputs($new_file, '$main_db_character_set=\'' . $db_character_set . '\';');
            fputs($new_file, "\n");

            fputs($new_file, '$main_db_collation=\'' . $db_collation . '\';');
            fputs($new_file, "\n");

            fputs($new_file, '$main_application_title=\'' . $application_title . '\';');
            fputs($new_file, "\n");

            fclose($new_file);

            $conn = null;

            header('Location: step2.php');
        }
        $conn = null;
    }
    $conn = null;
}

/*
 * View
 */

print $twig->render(
    'step1.body.html.twig',
    [
        'langs'        => $langs,
        'main_url'     => PM_INSTALL_MAIN_URL,
        'root_folder'  => PM_INSTALL_APP_ROOT_FOLDER,
        'lockerror'    => $lockerror,
        'installerror' => $installerror,
        'title'        => $langs->trans('InstallConfigure'),
        'ses_error'    => $error,
        'db_error'     => $dberror,
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
