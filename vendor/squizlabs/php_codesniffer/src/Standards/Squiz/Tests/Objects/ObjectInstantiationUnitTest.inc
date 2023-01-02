<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ObjectInstantiationUnitTest.inc
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

$obj = new MyClass();
$obj =& new MyClass();
$obj = &new MyClass();
new MyClass();

$objects = array('one' => new MyClass());
$object->myFunction(new MyClass());

throw new MyException($msg);

function foo() { return new MyClass(); }

$doodad = $x ? new Foo() : new Bar();

function returnFn() {
    $fn = fn($x) => new MyClass();
}

function returnMatch() {
    $match = match($x) {
        0 => new MyClass()
    }
}

// Issue 3333.
$time2 ??= new DateTime();
$time3 = $time1 ?? new DateTime();
$time3 = $time1 ?? $time2 ?? new DateTime();

function_call($time1 ?? new DateTime());
$return = function_call($time1 ?? new DateTime()); // False negative depending on interpretation of the sniff.

function returnViaTernary() {
    return ($y == false ) ? ($x === true ? new Foo() : new Bar()) : new FooBar();
}

function nonAssignmentTernary() {
    if (($x ? new Foo() : new Bar()) instanceof FooBar) {
        // Do something.
    }
}

// Intentional parse error. This must be the last test in the file.
function new()
?>
