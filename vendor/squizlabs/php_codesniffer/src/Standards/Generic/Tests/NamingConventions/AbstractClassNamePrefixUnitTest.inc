<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: AbstractClassNamePrefixUnitTest.inc
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

abstract class IncorrectName // error
{

}

abstract class AbstractCorrectName
{

}

abstract class IncorrectNameAbstract // error
{

}

abstract class InvalidNameabstract // error
{

}

abstract class IncorrectAbstractName // error
{

}

$anon = new class {};

class AbstractClassName
{

}

if (!class_exists('AbstractClassCorrectName')) {
    abstract class AbstractClassCorrectName
    {

    }
}
if (!class_exists('ClassAbstractIncorrectName')) {
    abstract class ClassAbstractIncorrectName // error
    {

    }
}

$abstractVar = '';

$var = 'abstract class IncorrectNameButOk';

$abstracVar = '';

class NameAbstractBar {}

abstract class abstractOkName
{

}