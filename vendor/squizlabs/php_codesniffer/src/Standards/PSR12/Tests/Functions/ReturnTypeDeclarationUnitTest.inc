<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ReturnTypeDeclarationUnitTest.inc
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

public function functionName(int $arg1, $arg2): string
{
    return 'foo';
}

public function anotherFunction(
    int $baz
): string {
    return 'foo';
}

$longArgs_noVars = function (
    $longArgument,
): string {
   // body
};

$shortArgs_longVars = function ($arg) use (
    $longVar1,
): string {
   // body
};

public function functionName(int $arg1, $arg2)
:
string
{
    return 'foo';
}

public function anotherFunction(
    int $baz
)  :  string {
    return 'foo';
}

$longArgs_noVars = function (
    $longArgument,
) :string {
   // body
};

$shortArgs_longVars = function ($arg) use (
    $longVar1,
)
:string {
   // body
};

public function functionName(int $arg1, $arg2) /* can't fix */ : string {}

public function functionName(int $arg1, $arg2) /* can't fix */
: // phpcs:ignore Standard.Category.Sniff
string {}

function functionName(?string $arg1, ?int &$arg2): ?string {}
function functionName(?string $arg1, ?int &$arg2):?string {}
function functionName(?string $arg1, ?int &$arg2):  ?string {}
function functionName(?string $arg1, ?int &$arg2):
?string {}

fn (?DateTime $arg) : ?DateTime => $arg;

return (!$a ? [ new class { public function b(): c {} } ] : []);
