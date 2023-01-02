<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ValidFunctionNameSniff.php
 *  Last Modified: 18.06.22 г., 10:21 ч.
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
 * Ensures method names are correct.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Sniffs\NamingConventions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\PEAR\Sniffs\NamingConventions\ValidFunctionNameSniff as PEARValidFunctionNameSniff;
use PHP_CodeSniffer\Util\Common;

class ValidFunctionNameSniff extends PEARValidFunctionNameSniff
{


    /**
     * Processes the tokens outside the scope.
     *
     * @param File $phpcsFile                        The file being processed.
     * @param int  $stackPtr                         The position where this token was
     *                                               found.
     *
     * @return void
     */
    protected function processTokenOutsideScope(File $phpcsFile, $stackPtr)
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);
        if ($functionName === null) {
            return;
        }

        $errorData = [$functionName];

        // Does this function claim to be magical?
        if (preg_match('|^__[^_]|', $functionName) !== 0) {
            $error = 'Function name "%s" is invalid; only PHP magic methods should be prefixed with a double underscore';
            $phpcsFile->addError($error, $stackPtr, 'DoubleUnderscore', $errorData);

            $functionName = ltrim($functionName, '_');
        }

        if (Common::isCamelCaps($functionName, false, true, false) === false) {
            $error = 'Function name "%s" is not in camel caps format';
            $phpcsFile->addError($error, $stackPtr, 'NotCamelCaps', $errorData);
        }

    }//end processTokenOutsideScope()


}//end class
