<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: MemberVarScopeUnitTest.inc
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

class MyClass
{
    private $var1 = null;
    protected ?int $var2 = null;
    public $var3 = null;
    $var4 = null;
}

class foo
{

    public const bar = <<<BAZ
qux
BAZ;
}

class Foo {
    public static function default(): ObjectA
    {
        return new self(1);
    }
}//end class

class MyClass {
    $anonFunc = function($foo) use ($bar) {}

public $anonFunc2 = function($foo2) use ($bar2) {};
    public function method($var1, $var2) {
        $anon = new class {
            $p1 = null;
            public $p2;
            protected $p3;
            private $p4;
            $p5 = null;

            public function m($x) {
                $y = $x + 1;

                $xAnon = new class {
                    $g1;
                    public $g2;
                    $g3 = null;
                };

                $anonFunc = function($foo) use ($bar) {
                    $x = true;
                };

                $z = 2 * $y;

                return $y ?: $z;
            }
        };

        $var = null;
    }

    public string $mCounter, $mSearchUser, $mSearchPeriodStart, $mSearchPeriodEnd,
    $mTestFilter;

    protected $mCounter,
        $mSearchUser,
        $mSearchPeriodStart,
        $mSearchPeriodEnd,
        $mTestFilter;

    var $mCounter, $mSearchUser,
        $mSearchPeriodStart;
}

interface Base {
    protected $anonymous;
}
