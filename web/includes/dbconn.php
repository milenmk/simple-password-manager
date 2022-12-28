<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: dbconn.php
 *  Last Modified: 28.12.22 г., 1:35 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0
 * @version       1.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 **/

declare(strict_types = 1);

/**
 * \file        class/dbconn.php
 * \brief       This file is a CRUD class file for ${MODULE_NAME} (Create/Read/Update/Delete)
 */

global $db_host, $db_name, $db_port, $db_user, $db_pass;

try {
	//$conn = new PDO("mysql:host=$servername;dbname=".$db, $username, $password);
	$conn = new PDO("mysql:host=$db_host;dbname=$db_name;port=$db_port", $db_user, $db_pass);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo 'Connected successfully';
}
catch (PDOException $e) {
	$error = 'Connection failed: ' . $e->getMessage();
}
