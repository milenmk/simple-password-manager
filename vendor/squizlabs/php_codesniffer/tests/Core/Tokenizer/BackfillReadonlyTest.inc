<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: BackfillReadonlyTest.inc
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

class Foo
{
    /* testReadonlyProperty */
    readonly int $readonlyProperty;
    /* testVarReadonlyProperty */
    var readonly int $varReadonlyProperty;
    /* testReadonlyVarProperty */
    readonly var int $testReadonlyVarProperty;
    /* testStaticReadonlyProperty */
    static readonly int $staticReadonlyProperty;
    /* testReadonlyStaticProperty */
    readonly static int $readonlyStaticProperty;
    /* testConstReadonlyProperty */
    public readonly const MYCONSTANT = 'foo';
    /* testReadonlyPropertyWithoutType */
    readonly $propertyWithoutType;
    /* testPublicReadonlyProperty */
    public readonly int $publicReadonlyProperty;
    /* testProtectedReadonlyProperty */
    protected readonly int $protectedReadonlyProperty;
    /* testPrivateReadonlyProperty */
    private readonly int $privateReadonlyProperty;
    /* testPublicReadonlyPropertyWithReadonlyFirst */
    readonly public int $publicReadonlyProperty;
    /* testProtectedReadonlyPropertyWithReadonlyFirst */
    readonly protected int $protectedReadonlyProperty;
    /* testPrivateReadonlyPropertyWithReadonlyFirst */
    readonly private int $privateReadonlyProperty;
    /* testReadonlyWithCommentsInDeclaration */
    private /* Comment */ readonly /* Comment */ int /* Comment */ $readonlyPropertyWithCommentsInDeclaration;
    /* testReadonlyWithNullableProperty */
    private readonly ?int $nullableProperty;
    /* testReadonlyNullablePropertyWithUnionTypeHintAndNullFirst */
    private readonly null|int $nullablePropertyWithUnionTypeHintAndNullFirst;
    /* testReadonlyNullablePropertyWithUnionTypeHintAndNullLast */
    private readonly int|null $nullablePropertyWithUnionTypeHintAndNullLast;
    /* testReadonlyPropertyWithArrayTypeHint */
    private readonly array $arrayProperty;
    /* testReadonlyPropertyWithSelfTypeHint */
    private readonly self $selfProperty;
    /* testReadonlyPropertyWithParentTypeHint */
    private readonly parent $parentProperty;
    /* testReadonlyPropertyWithFullyQualifiedTypeHint */
    private readonly \stdClass $propertyWithFullyQualifiedTypeHint;

    /* testReadonlyIsCaseInsensitive */
    public ReAdOnLy string $caseInsensitiveProperty;

    /* testReadonlyConstructorPropertyPromotion */
    public function __construct(private readonly bool $constructorPropertyPromotion)
    {
    }

    /* testReadonlyConstructorPropertyPromotionWithReference */
    public function __construct(private ReadOnly bool &$constructorPropertyPromotion) {}
}

$anonymousClass = new class () {
    /* testReadonlyPropertyInAnonymousClass */
    public readonly int $property;
};

class ClassName {
    /* testReadonlyUsedAsClassConstantName */
    const READONLY = 'readonly';

    /* testReadonlyUsedAsMethodName */
    public function readonly() {
        // Do something.

        /* testReadonlyUsedAsPropertyName */
        $this->readonly = 'foo';

        /* testReadonlyPropertyInTernaryOperator */
        $isReadonly = $this->readonly ? true : false;
    }
}

/* testReadonlyUsedAsFunctionName */
function readonly()
{
}

/* testReadonlyUsedAsNamespaceName */
namespace Readonly;
/* testReadonlyUsedAsPartOfNamespaceName */
namespace My\Readonly\Collection;
/* testReadonlyAsFunctionCall */
$var = readonly($a, $b);
/* testClassConstantFetchWithReadonlyAsConstantName */
echo ClassName::READONLY;

/* testReadonlyUsedAsFunctionCallWithSpaceBetweenKeywordAndParens */
$var = readonly /* comment */ ();

/* testParseErrorLiveCoding */
// This must be the last test in the file.
readonly
