<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ConcatenationSpacingUnitTest.inc
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

$string = 'Hello'.$there.'. How are'.$you.$going."today $okay";
$string = 'Hello' . $there . '. How are' . $you . $going . "today $okay";
$string = 'Hello'.$there;
$string = 'Hello'. $there;
$string = 'Hello' .$there;

$y = '1'
   . '2'
   . '3';

echo 1 . 'test';
echo 1.1 . 'test';
echo 'test' . 1;
echo 'test' . 1.1;
echo 'test' . 1 . 'test' . 2.2 . 'test'   .   3;

get_current_screen()->add_help_tab( array(
'id'        => <<<EOD
Here comes some text.
EOD
. '</hr>',
) );

// phpcs:set Squiz.Strings.ConcatenationSpacing spacing 1

$string = 'Hello'.$there.'. How are'.$you.$going.   "today $okay";
$string = 'Hello' . $there . '. How are' . $you . $going . "today $okay";
$string = 'Hello'.$there;
$string = 'Hello'. $there;
$string = 'Hello' .$there;

// phpcs:set Squiz.Strings.ConcatenationSpacing ignoreNewlines true
$y = '1'
   . '2'
   . '3';

$y = '1' .
     '2' .
     '3';

$y = '1'
. '2'
. '3';

$y = '1'
   .'2'.
    '3'
   .  '4';
