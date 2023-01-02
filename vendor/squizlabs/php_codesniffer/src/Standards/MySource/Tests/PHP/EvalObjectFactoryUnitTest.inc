<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: EvalObjectFactoryUnitTest.inc
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

function getWidget($type)
{
    eval('$obj = new '.$type.'();');
    return $obj;

}//end getWidget()

function getWidget2($type)
{
    $string = '$obj = new '.$type.'();';
    eval($string);
    eval('$string = "";');
    return $obj;

}//end getWidget2()

function getWidget3($type)
{
    $string = '$obj = new ';
    eval($string.$type.'();');
    return $obj;

}//end getWidget3()

?>