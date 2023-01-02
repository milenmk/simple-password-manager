<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: TypeIntersectionTest.inc
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
 * Type intersection or bitwise and.
 */

/* testBitwiseAnd1 */

use Fully\Qualified\NameA;
use Fully\Qualified\NameB;
use Package\MyA;

$result = $value & $test /* testBitwiseAnd2 */ & $another;

class TypeIntersection
{
    /* testTypeIntersectionPropertySimple */
    public static Foo&Bar $obj;

    /* testTypeIntersectionPropertyReverseModifierOrder */
    protected static Something&Nothing $somethingNothing /* testBitwiseAndPropertyDefaultValue */ = E_WARNING & E_NOTICE;

    private
        /* testTypeIntersectionPropertyMulti1 */
        Foo &
        /* testTypeIntersectionPropertyMulti2 */
        Traversable & // phpcs:ignore Stnd.Cat.Sniff
        Boo
        /* testTypeIntersectionPropertyMulti3 */
        & Bar $multi;

    /* testTypeIntersectionPropertyNamespaceRelative */
    public namespace\Sub\NameA&namespace\Sub\NameB $namespaceRelative;

    /* testTypeIntersectionPropertyPartiallyQualified */
    public Partially\Qualified\NameA&Partially\Qualified\NameB $partiallyQual;

    /* testTypeIntersectionPropertyFullyQualified */
    public NameA&NameB $fullyQual;

    /* testTypeIntersectionPropertyWithReadOnlyKeyword */
    protected readonly Foo&Bar $fooBar;

    public function paramTypes(
        /* testTypeIntersectionParam1 */
        Foo&Bar                                       $paramA /* testBitwiseAndParamDefaultValue */ = CONSTANT_A & CONSTANT_B,

        /* testTypeIntersectionParam2 */
        Foo&Bar /* testTypeIntersectionParam3 */ &Baz /* testBitwiseAnd3 */ &...$paramB = null,
    ) {
        /* testBitwiseAnd4 */
        return (($a1 ^ $b1) &($a2 ^ $b2)) + $c;
    }

    public function identifierNames(
        /* testTypeIntersectionParamNamespaceRelative */
        namespace\Sub\NameA&namespace\Sub\NameB             $paramA,
        /* testTypeIntersectionParamPartiallyQualified */
        Partially\Qualified\NameA&Partially\Qualified\NameB $paramB,
        /* testTypeIntersectionParamFullyQualified */
        NameA&NameB                        $paramC,
    ) {}

    /* testTypeIntersectionReturnType */
    public function returnType() : Foo&Bar {}

    /* testTypeIntersectionConstructorPropertyPromotion */
    public function __construct( public Foo&Bar $property) {}

    /* testTypeIntersectionAbstractMethodReturnType1 */
    abstract public function abstractMethod(): Foo&Bar /* testTypeIntersectionAbstractMethodReturnType2 */ &Baz;

    /* testTypeIntersectionReturnTypeNamespaceRelative */
    public function identifierNamesReturnRelative() : namespace\Sub\NameA&namespace\Sub\NameB {}

    /* testTypeIntersectionReturnPartiallyQualified */
    public function identifierNamesReturnPQ() : Partially\Qualified\NameA&Partially\Qualified\NameB {}

    /* testTypeIntersectionReturnFullyQualified */
    public function identifierNamesReturnFQ() : NameA&NameB {}
}

/* testTypeIntersectionClosureParamIllegalNullable */
$closureWithParamType = function (?Foo&Bar $string) {};

function globalFunctionWithSpreadAndReference(
    /* testTypeIntersectionWithReference */
    Foo&Bar /* testBitwiseAnd5 */ &$paramA,
    /* testTypeIntersectionWithSpreadOperator */
    Foo&Bar ...$paramB
) {}

/* testBitwiseAndClosureParamDefault */
$closureWithReturnType = function ($string = NONSENSE & FAKE)/* testTypeIntersectionClosureReturn */ : MyA&PackageB {};

/* testTypeIntersectionArrowParam */
$arrowWithParamType = fn (Foo&Bar $param, /* testBitwiseAndArrowParamDefault */ ?int $int = CONSTA & CONSTB )
    /* testBitwiseAndArrowExpression */
    => $param & $int;

/* testTypeIntersectionArrowReturnType */
$arrowWithReturnType = fn ($param) : Foo&Bar => $param * 10;

/* testBitwiseAndInArrayKey */
$array = array(
    A & B => /* testBitwiseAndInArrayValue */ B & C
);

/* testBitwiseAndInShortArrayKey */
$array = [
    A & B => /* testBitwiseAndInShortArrayValue */ B & C
];

/* testBitwiseAndNonArrowFnFunctionCall */
$obj->fn($something & $else);

/* testBitwiseAnd6 */
function &fn(/* testTypeIntersectionNonArrowFunctionDeclaration */ Foo&Bar $something) {}

/* testTypeIntersectionWithInvalidTypes */
function (int&string $var) {};

/* testLiveCoding */
// Intentional parse error. This has to be the last test in the file.
return function( Foo&
