<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: GetMethodPropertiesTest.inc
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

use Package\MyClassB;
use Package\MyClassC;

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: GetMethodPropertiesTest.inc
 *  Last Modified: 18.06.22 г., 10:21 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       2.2.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/* testBasicFunction */
function myFunction() {}

/* testReturnFunction */
function myFunction(array ...$arrays): array
{

    /* testNestedClosure */
    return array_map(
        function (array $array): int {

            return array_sum($array);
        }, $arrays
    );
}

interface MyInterface
{

    /* testInterfaceMethod */
    public function myFunction();

}

interface FooBar
{

    public function pseudoTypeIterableAndArray(): iterable|array|Traversable;

}

class MyClass
{

    /* testBasicMethod */
    private static function myFunction() {}

    /* testPrivateStaticMethod */

    public function myFunction() {}

    /* testFinalMethod */

    final public function myFunction() {}

    /* testProtectedReturnMethod */

    public function myFunction(): array {}

    /* testPublicReturnMethod */

    public function myFunction(): ?array {}

    /* testNullableReturnMethod */

    public function myFunction() /* comment
        */ :
        /* comment */ ? //comment
    array {}

    /* testMessyNullableReturnMethod */

    public function myFunction(): \MyNamespace\MyClass {}

    /* testReturnNamespace */

    public function myFunction(): \MyNamespace /** comment *\/ comment */
    \MyClass /* comment */
    \Foo {}

    /* testReturnMultilineNamespace */

    protected function myFunction(): int {}

}

$result = array_map(
/* testArrowFunction */
    static fn(int $number): int => $number + 1,
    $numbers
);

abstract class MyClass
{

    /* testAbstractMethod */
    abstract public function myFunction();

    /* testAbstractReturnMethod */
    abstract protected function myFunction(): bool;

}

/* testPHP8MixedTypeHint */
function mixedTypeHint(): mixed {}

/* testPHP8MixedTypeHintNullable */
// Intentional fatal error - nullability is not allowed with mixed, but that's not the concern of the method.
function mixedTypeHintNullable(): ?mixed {}

/* testNamespaceOperatorTypeHint */
function namespaceOperatorTypeHint(): ?namespace\Name {}

/* testPHP8UnionTypesSimple */
function unionTypeSimple($number): int|float {}

/* testPHP8UnionTypesTwoClasses */
$fn = fn($var): MyClassA|MyClassB => $var;

/* testPHP8UnionTypesAllBaseTypes */
function unionTypesAllBaseTypes(): array|bool|callable|int|float|null|object|string {}

/* testPHP8UnionTypesAllPseudoTypes */
// Intentional fatal error - mixing types which cannot be combined, but that's not the concern of the method.
function unionTypesAllPseudoTypes($var): false|MIXED|self|parent|static|iterable|Resource|void {}

/* testPHP8UnionTypesNullable */
// Intentional fatal error - nullability is not allowed with union types, but that's not the concern of the method.
$closure = function () use ($a): ?int|float {};

/* testPHP8PseudoTypeNull */
// Intentional fatal error - null pseudotype is only allowed in union types, but that's not the concern of the method.
function pseudoTypeNull(): null {}

/* testPHP8PseudoTypeFalse */
// Intentional fatal error - false pseudotype is only allowed in union types, but that's not the concern of the method.
function pseudoTypeFalse(): false {}

/* testPHP8PseudoTypeFalseAndBool */
// Intentional fatal error - false pseudotype is not allowed in combination with bool, but that's not the concern of the method.
function pseudoTypeFalseAndBool(): bool|false {}

/* testPHP8ObjectAndClass */
// Intentional fatal error - object is not allowed in combination with class name, but that's not the concern of the method.
function objectAndClass(): object|ClassName {}

/* testPHP8PseudoTypeIterableAndArray */

// Intentional fatal error - iterable pseudotype is not allowed in combination with array or Traversable, but that's not the concern of the method.

class ReturnMe
{

    /* testReturnTypeStatic */
    private function myFunction(): static
    {

        return $this;
    }

}

/* testPHP8DuplicateTypeInUnionWhitespaceAndComment */
// Intentional fatal error - duplicate types are not allowed in union types, but that's not the concern of the method.
function duplicateTypeInUnion(): int| /*comment*/ string|int {}

/* testPHP81NeverType */
function never(): never {}

/* testPHP81NullableNeverType */
// Intentional fatal error - nullability is not allowed with never, but that's not the concern of the method.
function nullableNever(): ?never {}

/* testPHP8IntersectionTypes */
function intersectionTypes(): Foo&Bar {}

/* testPHP81MoreIntersectionTypes */
function moreIntersectionTypes(): MyClassA&MyClassB&MyClassC {}

/* testPHP81IntersectionArrowFunction */
$fn = fn($var): MyClassA&MyClassB => $var;

/* testPHP81IllegalIntersectionTypes */
// Intentional fatal error - simple types are not allowed with intersection types, but that's not the concern of the method.
$closure = function (): string&int {};

/* testPHP81NullableIntersectionTypes */
// Intentional fatal error - nullability is not allowed with intersection types, but that's not the concern of the method.
$closure = function (): ?Foo&Bar {};
