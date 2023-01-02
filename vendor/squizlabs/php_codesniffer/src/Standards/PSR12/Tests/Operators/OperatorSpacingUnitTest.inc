<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: OperatorSpacingUnitTest.inc
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

if ($a    ===$b) {
    $foo = $bar ??$a?? $b;
} elseif ($a> $b) {
    $variable =$foo ? 'foo' :'bar';
    $variable.='text'.'text';
}

$foo+= $a&$b;
$foo = $a|$b;
$foo =$a^$b;
$foo = ~$a;
$foo   *=$a<<$b;
$foo = $a>>$b;

function foo(&$a,& $b) {}

$foo = $a   and$b;
$foo = $a or   $b;
$foo = $a xor$b;
$foo = !$a;
$foo = $a&&$b;
$foo = $a||$b;

$foo = $a instanceof Foo;
$foo = $a instanceof$b;

$foo .= 'hi'
     .= 'there';

$foo .= 'hi'
.= 'there';

$foo .= 'hi' // comment
.= 'there';

$foo/*comment*/=/*comment*/$a/*comment*/and/*comment*/$b;

$foo .=//comment
'string' .=/*comment*/
'string';

$foo = $foo ?: 'bar';
$foo = $foo?:'bar';

try {
} catch (ExceptionType1|ExceptionType2 $e) {
}

if (strpos($tokenContent, 'b"') === 0 && substr($tokenContent, -1) === '"') {}

$oldConstructorPos = +1;
return -$content;

function name($a = -1) {}

$a =& $ref;
$a = [ 'a' => &$something ];

$fn = fn(array &$one) => 1;
$fn = fn(array & $one) => 1;

$fn = static fn(DateTime $a, DateTime $b): int => -($a->getTimestamp() <=> $b->getTimestamp());

function issue3267(string|int ...$values) {}

function setDefault(#[ImportValue(
        constraints: [
            [
                Assert\Type::class,
                ['type' => 'bool'],
            ],
        ]
    )] ?bool $value = null): void
    {
        // Do something
    }
