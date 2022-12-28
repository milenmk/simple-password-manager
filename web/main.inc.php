<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: main.inc.php
 *  Last Modified: 27.12.22 г., 17:29 ч.
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
 * \file        class/main.inc.php
 * \brief       This file is a CRUD class file for ${MODULE_NAME} (Create/Read/Update/Delete)
 */

if (!file_exists('conf/conf.php')) {
	header('Location: install');
} else {
	include_once('conf/conf.php');
}

include_once('includes/dbconn.php');

include_once('functions.inc.php');