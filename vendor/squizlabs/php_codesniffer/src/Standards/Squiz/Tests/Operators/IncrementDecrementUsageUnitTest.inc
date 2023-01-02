<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: IncrementDecrementUsageUnitTest.inc
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

$var  = ($var + 1);
$var  = ($one + 1);
$var  = ($var + 2);
$var  = ($one + $two + 1);
$var += 1;
$var += 2;
$var += $one;
$var += (1 + 2)
$var  = myFunction($var, ($one + 1));

$var  = ($var - 1);
$var  = ($one - 1);
$var  = ($var - 2);
$var  = ($one - $two - 1);
$var -= 1;
$var -= 2;
$var -= $one;
$var -= (1 + 2)
$var  = myFunction($var, ($one - 1));

$var -= $var - 1;
$var += $var - 1;

$id = $id.'_'.($i-- - $x--).'_'.$x;
$id = $id.'_'.(++$i - $x--).'_'.$x;
$id = $id.'_'.(--$i - $x++).'_'.$x;

$id = $id.'_'.$i++;
$id = $id.'_'.($i++);
$id = $id.'_'.$i--.'_';
$id = $id.'_'.($i--).'_';

$var = (1 - $var);
$var = (1 + $var);

$expected[$i]['sort_order'] = ($i + 1);
$expected[($i + 1)]['sort_order'] = ($i + 1);

$id = $id.($obj->i++).$id;
$id = $obj?->i++.$id;
$id = $obj?->i++*10;
