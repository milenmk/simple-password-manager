<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: IncludeOwnSystemSniff.php
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
 * Ensures that a system does not include itself.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\MySource\Sniffs\Channels;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class IncludeOwnSystemSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_DOUBLE_COLON];

    }//end register()


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param File $phpcsFile                        The file being scanned.
     * @param int  $stackPtr                         The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $fileName = $phpcsFile->getFilename();
        $matches  = [];
        if (preg_match('|/systems/(.*)/([^/]+)?actions.inc$|i', $fileName, $matches) === 0) {
            // Not an actions file.
            return;
        }

        $ownClass = $matches[2];
        $tokens   = $phpcsFile->getTokens();

        $typeName = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, ($stackPtr + 2), null, false, true);
        $typeName = trim($tokens[$typeName]['content'], " '");
        switch (strtolower($tokens[($stackPtr + 1)]['content'])) {
        case 'includesystem' :
            $included = strtolower($typeName);
            break;
        case 'includeasset' :
            $included = strtolower($typeName).'assettype';
            break;
        case 'includewidget' :
            $included = strtolower($typeName).'widgettype';
            break;
        default:
            return;
        }

        if ($included === strtolower($ownClass)) {
            $error = "You do not need to include \"%s\" from within the system's own actions file";
            $data  = [$ownClass];
            $phpcsFile->addError($error, $stackPtr, 'NotRequired', $data);
        }

    }//end process()


    /**
     * Determines the included class name from given token.
     *
     * @param File  $phpcsFile                       The file where this token was found.
     * @param array $tokens                          The array of file tokens.
     * @param int   $stackPtr                        The position in the tokens array of the
     *                                               potentially included class.
     *
     * @return string
     */
    protected function getIncludedClassFromToken(
        $phpcsFile,
        array $tokens,
        $stackPtr
    ) {

        return false;

    }//end getIncludedClassFromToken()


}//end class
