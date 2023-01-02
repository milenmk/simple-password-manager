<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: LowercaseFunctionKeywordsUnitTest.inc
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

// Correct.
function Foo() {}
$a = function() {};

abstract class Foo
{

    public function PublicFunction() {}

    private function PrivateFunction() {}

    protected function ProtectedFunction() {}

    public static function StaticFunction() {}

    abstract protected function AbstractProtectedFunction();

    final public static function FinalStaticPublicFunction() {}

}

// Incorrect.
Function Bar() {}
$a = FUNCTION() {};

abstract class Bar
{

    public function PublicFunction() {}

    private function PrivateFunction() {}

    protected function ProtectedFunction() {}

    public static function StaticFunction() {}

    abstract protected function AbstractProtectedFunction();

    final public static function FinalStaticPublicFunction() {}

}

$a = FN($x) => $x;
