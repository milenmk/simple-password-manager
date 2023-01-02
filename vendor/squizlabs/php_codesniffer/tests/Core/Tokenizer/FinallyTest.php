<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FinallyTest.php
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
 * Tests the tokenization of the finally keyword.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2021 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizer;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

class FinallyTest extends AbstractMethodUnitTest
{

    /**
     * Test that the finally keyword is tokenized as such.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataFinallyKeyword
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testFinallyKeyword($testMarker)
    {

        $tokens = self::$phpcsFile->getTokens();

        $target = $this->getTargetToken($testMarker, [T_FINALLY, T_STRING]);
        $this->assertSame(T_FINALLY, $tokens[$target]['code']);
        $this->assertSame('T_FINALLY', $tokens[$target]['type']);
    }//end testFinallyKeyword()

    /**
     * Data provider.
     *
     * @return array
     * @see testFinallyKeyword()
     *
     */
    public function dataFinallyKeyword()
    {

        return [
            ['/* testTryCatchFinally */'],
            ['/* testTryFinallyCatch */'],
            ['/* testTryFinally */'],
        ];
    }//end dataFinallyKeyword()

    /**
     * Test that 'finally' when not used as the reserved keyword is tokenized as `T_STRING`.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataFinallyNonKeyword
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testFinallyNonKeyword($testMarker)
    {

        $tokens = self::$phpcsFile->getTokens();

        $target = $this->getTargetToken($testMarker, [T_FINALLY, T_STRING]);
        $this->assertSame(T_STRING, $tokens[$target]['code']);
        $this->assertSame('T_STRING', $tokens[$target]['type']);
    }//end testFinallyNonKeyword()

    /**
     * Data provider.
     *
     * @return array
     * @see testFinallyNonKeyword()
     *
     */
    public function dataFinallyNonKeyword()
    {

        return [
            ['/* testFinallyUsedAsClassConstantName */'],
            ['/* testFinallyUsedAsMethodName */'],
            ['/* testFinallyUsedAsPropertyName */'],
        ];
    }//end dataFinallyNonKeyword()

}//end class
