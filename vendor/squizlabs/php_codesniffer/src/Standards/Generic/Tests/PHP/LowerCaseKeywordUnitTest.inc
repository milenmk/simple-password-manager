<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: LowerCaseKeywordUnitTest.inc
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

// A few keywords. Obviously not valid syntax.
class Something extends SomethingElse implements Whatever {}
abstract public private protected function whatever() {}
const array();
foreach ($var as $var) { exit; }
if ($a and $b or $c xor $d) { die; } elseif( $var ) { } else {}
goto a;

Class Something EXTENDS SomethingElse implementS Whatever {}
Abstract Public Private Protected function whatever() {}
CONST array();
ForEach ($var As $var) { Exit; }
If ($a AND $b OR $c XOR $d) { Die; } ElseIf( $var ) { } Else {}
GOTO a;
$b = function (Array $a) {};
const PRIVATE
HttpStatus::CONTINUE;
$c = Function ($f) {
    Yield $f;
    Yield From fun();
};
class X extends Y {
    public function m() {
        Parent::m();
    }
    public function n() {
        Self::n();
    }
}
FN ($x) => $x;
$r = Match ($x) {
    1 => 1,
    2 => 2,
    DEFAULT, => 3,
};

class Reading {
    Public READOnly int $var;
}

EnuM ENUM: string
{
    Case HEARTS;
}

__HALT_COMPILER(); // An exception due to phar support.
function
