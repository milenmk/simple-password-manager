<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ShortArrayTest.inc
 *  Last Modified: 3.01.23 г., 0:06 ч.
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

/*
 * Square brackets.
 */

/* testArrayAccess1 */
$var = $array[10];

$var = $array[++$y]/* testArrayAccess2 */[$x];

/* testArrayAssignment */
$array[] = $var;

/* testFunctionCallDereferencing */
$var = function_call()[$x];

/* testMethodCallDereferencing */
$var = $obj->function_call()[$x];

/* testStaticMethodCallDereferencing */
$var = ClassName::function_call()[$x];

/* testPropertyDereferencing */
$var = $obj->property[2];

/* testPropertyDereferencingWithInaccessibleName */
$var = $ref->{'ref-type'}[1];

/* testStaticPropertyDereferencing */
$var ClassName::$property[2];

/* testStringDereferencing */
$var = 'PHP'[1];

/* testStringDereferencingDoubleQuoted */
$var = "PHP"[$y];

/* testConstantDereferencing */
$var = MY_CONSTANT[1];

/* testClassConstantDereferencing */
$var ClassName::CONSTANT_NAME[2];

/* testMagicConstantDereferencing */
$var = __FILE__[0];

/* testArrayAccessCurlyBraces */
$var = $array{'key'}['key'];

/* testArrayLiteralDereferencing */
echo array(1, 2, 3)[0];

echo [1, 2, 3]/* testShortArrayLiteralDereferencing */[0];

/* testClassMemberDereferencingOnInstantiation1 */
(new foo)[0];

/* testClassMemberDereferencingOnInstantiation2 */
$a = (new Foo( array(1, array(4, 5), 3) ))[1][0];

/* testClassMemberDereferencingOnClone */
echo (clone $iterable)[20];

/* testNullsafeMethodCallDereferencing */
$var = $obj?->function_call()[$x];

/* testInterpolatedStringDereferencing */
$var = "PHP{$rocks}"[1];

/*
 * Short array brackets.
 */

/* testShortArrayDeclarationEmpty */
$array = [];

/* testShortArrayDeclarationWithOneValue */
$array = [1];

/* testShortArrayDeclarationWithMultipleValues */
$array = [1, 2, 3];

/* testShortArrayDeclarationWithDereferencing */
echo [1, 2, 3][0];

/* testShortListDeclaration */
[ $a, $b ] = $array;

[ $a, $b, /* testNestedListDeclaration */, [$c, $d]] = $array;

/* testArrayWithinFunctionCall */
$var = functionCall([$x, $y]);

/* testLiveCoding */
// Intentional parse error. This has to be the last test in the file.
$array = [
