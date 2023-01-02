<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DisallowRequestSuperglobalUnitTest.inc
 *  Last Modified: 18.06.22 г., 10:21 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.2.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

echo $_REQUEST['action'];

echo '$_REQUEST';

echo $_POST['action'];

echo $_GET[$action];

echo $_COOKIE['action'];

$sample = Util::getArrayIndex($_REQUEST, 'sample', '');
$syntax = Util::getArrayIndex($_REQUEST, 'syntax', '');
$value  = Util::getArrayIndex($_FILES, $key, $default);

?>
