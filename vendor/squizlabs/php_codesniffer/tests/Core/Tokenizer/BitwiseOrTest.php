<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: BitwiseOrTest.php
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
 * Tests the conversion of bitwise or tokens to type union tokens.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2020 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizer;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

class BitwiseOrTest extends AbstractMethodUnitTest
{

    /**
     * Test that non-union type bitwise or tokens are still tokenized as bitwise or.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataBitwiseOr
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::processAdditional
     *
     * @return void
     */
    public function testBitwiseOr($testMarker)
    {

        $tokens = self::$phpcsFile->getTokens();

        $opener = $this->getTargetToken($testMarker, [T_BITWISE_OR, T_TYPE_UNION]);
        $this->assertSame(T_BITWISE_OR, $tokens[$opener]['code']);
        $this->assertSame('T_BITWISE_OR', $tokens[$opener]['type']);
    }//end testBitwiseOr()

    /**
     * Data provider.
     *
     * @return array
     * @see testBitwiseOr()
     *
     */
    public function dataBitwiseOr()
    {

        return [
            ['/* testBitwiseOr1 */'],
            ['/* testBitwiseOr2 */'],
            ['/* testBitwiseOrPropertyDefaultValue */'],
            ['/* testBitwiseOrParamDefaultValue */'],
            ['/* testBitwiseOr3 */'],
            ['/* testBitwiseOrClosureParamDefault */'],
            ['/* testBitwiseOrArrowParamDefault */'],
            ['/* testBitwiseOrArrowExpression */'],
            ['/* testBitwiseOrInArrayKey */'],
            ['/* testBitwiseOrInArrayValue */'],
            ['/* testBitwiseOrInShortArrayKey */'],
            ['/* testBitwiseOrInShortArrayValue */'],
            ['/* testBitwiseOrTryCatch */'],
            ['/* testBitwiseOrNonArrowFnFunctionCall */'],
            ['/* testLiveCoding */'],
        ];
    }//end dataBitwiseOr()

    /**
     * Test that bitwise or tokens when used as part of a union type are tokenized as `T_TYPE_UNION`.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataTypeUnion
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::processAdditional
     *
     * @return void
     */
    public function testTypeUnion($testMarker)
    {

        $tokens = self::$phpcsFile->getTokens();

        $opener = $this->getTargetToken($testMarker, [T_BITWISE_OR, T_TYPE_UNION]);
        $this->assertSame(T_TYPE_UNION, $tokens[$opener]['code']);
        $this->assertSame('T_TYPE_UNION', $tokens[$opener]['type']);
    }//end testTypeUnion()

    /**
     * Data provider.
     *
     * @return array
     * @see testTypeUnion()
     *
     */
    public function dataTypeUnion()
    {

        return [
            ['/* testTypeUnionPropertySimple */'],
            ['/* testTypeUnionPropertyReverseModifierOrder */'],
            ['/* testTypeUnionPropertyMulti1 */'],
            ['/* testTypeUnionPropertyMulti2 */'],
            ['/* testTypeUnionPropertyMulti3 */'],
            ['/* testTypeUnionPropertyNamespaceRelative */'],
            ['/* testTypeUnionPropertyPartiallyQualified */'],
            ['/* testTypeUnionPropertyFullyQualified */'],
            ['/* testTypeUnionPropertyWithReadOnlyKeyword */'],
            ['/* testTypeUnionPropertyWithReadOnlyKeywordFirst */'],
            ['/* testTypeUnionPropertyWithStaticAndReadOnlyKeywords */'],
            ['/* testTypeUnionPropertyWithVarAndReadOnlyKeywords */'],
            ['/* testTypeUnionPropertyWithOnlyReadOnlyKeyword */'],
            ['/* testTypeUnionParam1 */'],
            ['/* testTypeUnionParam2 */'],
            ['/* testTypeUnionParam3 */'],
            ['/* testTypeUnionParamNamespaceRelative */'],
            ['/* testTypeUnionParamPartiallyQualified */'],
            ['/* testTypeUnionParamFullyQualified */'],
            ['/* testTypeUnionReturnType */'],
            ['/* testTypeUnionConstructorPropertyPromotion */'],
            ['/* testTypeUnionAbstractMethodReturnType1 */'],
            ['/* testTypeUnionAbstractMethodReturnType2 */'],
            ['/* testTypeUnionReturnTypeNamespaceRelative */'],
            ['/* testTypeUnionReturnPartiallyQualified */'],
            ['/* testTypeUnionReturnFullyQualified */'],
            ['/* testTypeUnionClosureParamIllegalNullable */'],
            ['/* testTypeUnionWithReference */'],
            ['/* testTypeUnionWithSpreadOperator */'],
            ['/* testTypeUnionClosureReturn */'],
            ['/* testTypeUnionArrowParam */'],
            ['/* testTypeUnionArrowReturnType */'],
            ['/* testTypeUnionNonArrowFunctionDeclaration */'],
        ];
    }//end dataTypeUnion()

}//end class
