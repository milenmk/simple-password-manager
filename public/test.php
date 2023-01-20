<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: test.php
 *  Last Modified: 19.01.23 г., 23:25 ч.
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

require_once('../docs/secret.key');


$password = '00124rth';

$passcrypted = openssl_encrypt($password, $ciphering, $encryption_key, $options, $encryption_iv);

print $passcrypted . '<br>';

$passdecrypted = openssl_decrypt($passcrypted, $ciphering, $encryption_key, $options, $encryption_iv);

print $passdecrypted;