<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: BackfillReadonlyTest.php
 *  Last Modified: 3.01.23 г., 0:07 ч.
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

/**
 * Tests the support of PHP 8.1 "readonly" keyword.
 *
 * @author    Jaroslav Hanslík <kukulich@kukulich.cz>
 * @copyright 2021 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizer;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

class BackfillReadonlyTest extends AbstractMethodUnitTest
{

    /**
     * Test that the "readonly" keyword is tokenized as such.
     *
     * @param string $testMarker  The comment which prefaces the target token in the test file.
     * @param string $testContent The token content to look for.
     *
     * @dataProvider dataReadonly
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::processAdditional
     *
     * @return void
     */
    public function testReadonly($testMarker, $testContent)
    {

        $tokens = self::$phpcsFile->getTokens();

        $target = $this->getTargetToken($testMarker, [T_READONLY, T_STRING], $testContent);
        $this->assertSame(T_READONLY, $tokens[$target]['code']);
        $this->assertSame('T_READONLY', $tokens[$target]['type']);
    }//end testReadonly()

    /**
     * Data provider.
     *
     * @return array
     * @see testReadonly()
     *
     */
    public function dataReadonly()
    {

        return [
            [
                '/* testReadonlyProperty */',
                'readonly',
            ],
            [
                '/* testVarReadonlyProperty */',
                'readonly',
            ],
            [
                '/* testReadonlyVarProperty */',
                'readonly',
            ],
            [
                '/* testStaticReadonlyProperty */',
                'readonly',
            ],
            [
                '/* testReadonlyStaticProperty */',
                'readonly',
            ],
            [
                '/* testConstReadonlyProperty */',
                'readonly',
            ],
            [
                '/* testReadonlyPropertyWithoutType */',
                'readonly',
            ],
            [
                '/* testPublicReadonlyProperty */',
                'readonly',
            ],
            [
                '/* testProtectedReadonlyProperty */',
                'readonly',
            ],
            [
                '/* testPrivateReadonlyProperty */',
                'readonly',
            ],
            [
                '/* testPublicReadonlyPropertyWithReadonlyFirst */',
                'readonly',
            ],
            [
                '/* testProtectedReadonlyPropertyWithReadonlyFirst */',
                'readonly',
            ],
            [
                '/* testPrivateReadonlyPropertyWithReadonlyFirst */',
                'readonly',
            ],
            [
                '/* testReadonlyWithCommentsInDeclaration */',
                'readonly',
            ],
            [
                '/* testReadonlyWithNullableProperty */',
                'readonly',
            ],
            [
                '/* testReadonlyNullablePropertyWithUnionTypeHintAndNullFirst */',
                'readonly',
            ],
            [
                '/* testReadonlyNullablePropertyWithUnionTypeHintAndNullLast */',
                'readonly',
            ],
            [
                '/* testReadonlyPropertyWithArrayTypeHint */',
                'readonly',
            ],
            [
                '/* testReadonlyPropertyWithSelfTypeHint */',
                'readonly',
            ],
            [
                '/* testReadonlyPropertyWithParentTypeHint */',
                'readonly',
            ],
            [
                '/* testReadonlyPropertyWithFullyQualifiedTypeHint */',
                'readonly',
            ],
            [
                '/* testReadonlyIsCaseInsensitive */',
                'ReAdOnLy',
            ],
            [
                '/* testReadonlyConstructorPropertyPromotion */',
                'readonly',
            ],
            [
                '/* testReadonlyConstructorPropertyPromotionWithReference */',
                'ReadOnly',
            ],
            [
                '/* testReadonlyPropertyInAnonymousClass */',
                'readonly',
            ],
            [
                '/* testReadonlyUsedAsFunctionCallWithSpaceBetweenKeywordAndParens */',
                'readonly',
            ],
            [
                '/* testParseErrorLiveCoding */',
                'readonly',
            ],
        ];
    }//end dataReadonly()

    /**
     * Test that "readonly" when not used as the keyword is still tokenized as `T_STRING`.
     *
     * @param string $testMarker  The comment which prefaces the target token in the test file.
     * @param string $testContent The token content to look for.
     *
     * @dataProvider dataNotReadonly
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::processAdditional
     *
     * @return void
     */
    public function testNotReadonly($testMarker, $testContent)
    {

        $tokens = self::$phpcsFile->getTokens();

        $target = $this->getTargetToken($testMarker, [T_READONLY, T_STRING], $testContent);
        $this->assertSame(T_STRING, $tokens[$target]['code']);
        $this->assertSame('T_STRING', $tokens[$target]['type']);
    }//end testNotReadonly()

    /**
     * Data provider.
     *
     * @return array
     * @see testNotReadonly()
     *
     */
    public function dataNotReadonly()
    {

        return [
            [
                '/* testReadonlyUsedAsClassConstantName */',
                'READONLY',
            ],
            [
                '/* testReadonlyUsedAsMethodName */',
                'readonly',
            ],
            [
                '/* testReadonlyUsedAsPropertyName */',
                'readonly',
            ],
            [
                '/* testReadonlyPropertyInTernaryOperator */',
                'readonly',
            ],
            [
                '/* testReadonlyUsedAsFunctionName */',
                'readonly',
            ],
            [
                '/* testReadonlyUsedAsNamespaceName */',
                'Readonly',
            ],
            [
                '/* testReadonlyUsedAsPartOfNamespaceName */',
                'Readonly',
            ],
            [
                '/* testReadonlyAsFunctionCall */',
                'readonly',
            ],
            [
                '/* testClassConstantFetchWithReadonlyAsConstantName */',
                'READONLY',
            ],
        ];
    }//end dataNotReadonly()

}//end class
