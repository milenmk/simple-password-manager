<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UnnecessaryStringConcatUnitTest.inc
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

$x = 'My '.'string';
$x = 'My '. 1234;
$x = 'My '.$y.' test';

echo $data['my'.'index'];
echo $data['my'. 4];
echo $data['my'.$x];
echo $data[$x.$y.'My'.'String'];

$code = '$actions = array();'."\n";
$code = "$actions = array();"."\n";

// No errors for these because they are needed in some cases.
$code = ' ?'.'>';
$code = '<'.'?php ';

$string = 'This is a really long string. '
        . 'It is being used for errors. '
        . 'The message is not translated.';
?>
