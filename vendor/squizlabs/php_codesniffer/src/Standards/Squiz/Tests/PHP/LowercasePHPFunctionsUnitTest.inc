<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: LowercasePHPFunctionsUnitTest.inc
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

if (Function_Exists('myFunction') === TRUE) {
    $retval = MyFunction(true);
    $keys = Array_Keys($array);
}

function getType() {}

$obj = new Date();

$count = $object->Count();
$count = $object::Count();
$count = $object->count();
$count = $object::count();
class MyClass {
    public function Count() {}
}

function &Sort() {

}

$connection = new Db\Adapter\Pdo\Mysql($config);

namespace Strtolower\Silly;

use File;
use function str_Repeat;
use function strToUpper as somethingElse;
use function MyClass\WordsToUpper as UCWords; // Intentional redeclared function error.
use function strToUpper\NotTheFunction;

class ArrayUnique {}

$sillyComments = strToLower /*comment*/ ($string);

$callToGlobalFunction = STR_REPEAT($a, 2);
$callToGlobalFunction = /*comment*/ str_Repeat($a, 2);

$callToNamespacedFunction = MyNamespace /* phpcs:ignore Standard */ \STR_REPEAT($a, 2);
$callToNamespacedFunction = namespace\STR_REPEAT($a, 2); // Could potentially be false negative.

$filePath = new File($path);

$count = $object?->Count();
