<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: autoloader.inc.php
 *  Last Modified: 25.12.22 г., 20:31 ч.
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
 * \file        class/autoloader.inc.php
 * \brief       This file is a CRUD class file for ${MODULE_NAME} (Create/Read/Update/Delete)
 */

spl_autoload_register('myAutoLoader');

/**
 * @param string $className name of the class to be loaded
 */
function myAutoLoader(string $className)
{

	$path = MAIN_DOCUMENT_ROOT . '/class/';

	$extension = '.class.php';

	require_once $path . $className . $extension;
}

