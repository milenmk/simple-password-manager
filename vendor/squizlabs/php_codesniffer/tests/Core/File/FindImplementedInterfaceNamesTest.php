<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FindImplementedInterfaceNamesTest.php
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

/**
 * Tests for the \PHP_CodeSniffer\Files\File:findImplementedInterfaceNames method.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

class FindImplementedInterfaceNamesTest extends AbstractMethodUnitTest
{

    /**
     * Test retrieving the name(s) of the interfaces being implemented by a class.
     *
     * @param string $identifier Comment which precedes the test case.
     * @param bool   $expected   Expected function output.
     *
     * @dataProvider dataImplementedInterface
     *
     * @return void
     */
    public function testFindImplementedInterfaceNames($identifier, $expected)
    {

        $OOToken = $this->getTargetToken($identifier, [T_CLASS, T_ANON_CLASS, T_INTERFACE, T_ENUM]);
        $result = self::$phpcsFile->findImplementedInterfaceNames($OOToken);
        $this->assertSame($expected, $result);
    }//end testFindImplementedInterfaceNames()

    /**
     * Data provider for the FindImplementedInterfaceNames test.
     *
     * @return array
     * @see testFindImplementedInterfaceNames()
     *
     */
    public function dataImplementedInterface()
    {

        return [
            [
                '/* testImplementedClass */',
                ['testFIINInterface'],
            ],
            [
                '/* testMultiImplementedClass */',
                [
                    'testFIINInterface',
                    'testFIINInterface2',
                ],
            ],
            [
                '/* testNamespacedClass */',
                ['\PHP_CodeSniffer\Tests\Core\File\testFIINInterface'],
            ],
            [
                '/* testNonImplementedClass */',
                false,
            ],
            [
                '/* testInterface */',
                false,
            ],
            [
                '/* testClassThatExtendsAndImplements */',
                [
                    'InterfaceA',
                    '\NameSpaced\Cat\InterfaceB',
                ],
            ],
            [
                '/* testClassThatImplementsAndExtends */',
                [
                    '\InterfaceA',
                    'InterfaceB',
                ],
            ],
            [
                '/* testBackedEnumWithoutImplements */',
                false,
            ],
            [
                '/* testEnumImplements */',
                ['Colorful'],
            ],
            [
                '/* testBackedEnumImplements */',
                [
                    'Colorful',
                    '\Deck',
                ],
            ],
        ];
    }//end dataImplementedInterface()

}//end class
