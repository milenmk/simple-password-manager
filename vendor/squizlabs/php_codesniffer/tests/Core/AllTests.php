<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: AllTests.php
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
 * A test class for testing the core.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2006-2019 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core;

use PHP_CodeSniffer\Tests\FileList;
use PHPUnit\Framework\TestSuite;
use PHPUnit\TextUI\TestRunner;

class AllTests
{

    /**
     * Prepare the test runner.
     *
     * @return void
     */
    public static function main()
    {

        TestRunner::run(self::suite());
    }//end main()

    /**
     * Add all core unit tests into a test suite.
     *
     * @return TestSuite
     */
    public static function suite()
    {

        $suite = new TestSuite('PHP CodeSniffer Core');

        $testFileIterator = new FileList(__DIR__, '', '`Test\.php$`Di');
        foreach ($testFileIterator->fileIterator as $file) {
            if (strpos($file, 'AbstractMethodUnitTest.php') !== false) {
                continue;
            }

            include_once $file;

            $class = str_replace(__DIR__, '', $file);
            $class = str_replace('.php', '', $class);
            $class = str_replace('/', '\\', $class);
            $class = 'PHP_CodeSniffer\Tests\Core' . $class;

            $suite->addTestSuite($class);
        }

        return $suite;
    }//end suite()

}//end class
