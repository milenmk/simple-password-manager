<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ValidVariableNameSniff.php
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
 * Checks the naming of member variables.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PEAR\Sniffs\NamingConventions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;

class ValidVariableNameSniff extends AbstractVariableSniff
{


    /**
     * Processes class member variables.
     *
     * @param File $phpcsFile                        The file being scanned.
     * @param int  $stackPtr                         The position of the current token
     *                                               in the stack passed in $tokens.
     *
     * @return void
     */
    protected function processMemberVar(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $memberProps = $phpcsFile->getMemberProperties($stackPtr);
        if (empty($memberProps) === true) {
            return;
        }

        $memberName     = ltrim($tokens[$stackPtr]['content'], '$');
        $scope          = $memberProps['scope'];
        $scopeSpecified = $memberProps['scope_specified'];

        if ($memberProps['scope'] === 'private') {
            $isPublic = false;
        } else {
            $isPublic = true;
        }

        // If it's a private member, it must have an underscore on the front.
        if ($isPublic === false && $memberName[0] !== '_') {
            $error = 'Private member variable "%s" must be prefixed with an underscore';
            $data  = [$memberName];
            $phpcsFile->addError($error, $stackPtr, 'PrivateNoUnderscore', $data);
            return;
        }

        // If it's not a private member, it must not have an underscore on the front.
        if ($isPublic === true && $scopeSpecified === true && $memberName[0] === '_') {
            $error = '%s member variable "%s" must not be prefixed with an underscore';
            $data  = [
                ucfirst($scope),
                $memberName,
            ];
            $phpcsFile->addError($error, $stackPtr, 'PublicUnderscore', $data);
            return;
        }

    }//end processMemberVar()


    /**
     * Processes normal variables.
     *
     * @param File $phpcsFile The file where this token was found.
     * @param int  $stackPtr  The position where the token was found.
     *
     * @return void
     */
    protected function processVariable(File $phpcsFile, $stackPtr)
    {
        /*
            We don't care about normal variables.
        */

    }//end processVariable()


    /**
     * Processes variables in double quoted strings.
     *
     * @param File $phpcsFile The file where this token was found.
     * @param int  $stackPtr  The position where the token was found.
     *
     * @return void
     */
    protected function processVariableInString(File $phpcsFile, $stackPtr)
    {
        /*
            We don't care about normal variables.
        */

    }//end processVariableInString()


}//end class
