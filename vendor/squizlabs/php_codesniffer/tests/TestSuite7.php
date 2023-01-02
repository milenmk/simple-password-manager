<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: TestSuite7.php
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
 * A PHP_CodeSniffer specific test suite for PHPUnit.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests;

use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\TestSuite as PHPUnit_TestSuite;

class TestSuite extends PHPUnit_TestSuite
{

    /**
     * Runs the tests and collects their result in a TestResult.
     *
     * @param TestResult $result A test result.
     *
     * @return TestResult
     */
    public function run(TestResult $result = null): TestResult
    {

        $result = parent::run($result);
        printPHPCodeSnifferTestOutput();

        return $result;
    }//end run()

}//end class
