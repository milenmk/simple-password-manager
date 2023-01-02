<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: NoSilencedErrorsSniff.php
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
 * Throws an error or warning when any code prefixed with an asperand is encountered.
 *
 * <code>
 *  if (@in_array($array, $needle))
 *  {
 *      doSomething();
 *  }
 * </code>
 *
 * @author    Andy Brockhurst <abrock@yahoo-inc.com>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Sniffs\PHP;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class NoSilencedErrorsSniff implements Sniff
{

    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = false;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_ASPERAND];

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param File $phpcsFile                        The file being scanned.
     * @param int  $stackPtr                         The position of the current token
     *                                               in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        // Prepare the "Found" string to display.
        $contextLength  = 4;
        $endOfStatement = $phpcsFile->findEndOfStatement($stackPtr, [T_COMMA, T_COLON]);
        if (($endOfStatement - $stackPtr) < $contextLength) {
            $contextLength = ($endOfStatement - $stackPtr);
        }

        $found = $phpcsFile->getTokensAsString($stackPtr, $contextLength);
        $found = str_replace(["\t", "\n", "\r"], ' ', $found).'...';

        if ($this->error === true) {
            $error = 'Silencing errors is forbidden; found: %s';
            $phpcsFile->addError($error, $stackPtr, 'Forbidden', [$found]);
        } else {
            $error = 'Silencing errors is discouraged; found: %s';
            $phpcsFile->addWarning($error, $stackPtr, 'Discouraged', [$found]);
        }

    }//end process()


}//end class
