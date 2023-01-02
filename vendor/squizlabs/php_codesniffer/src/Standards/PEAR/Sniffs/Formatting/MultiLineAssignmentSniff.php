<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: MultiLineAssignmentSniff.php
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
 * If an assignment goes over two lines, ensure the equal sign is indented.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PEAR\Sniffs\Formatting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class MultiLineAssignmentSniff implements Sniff
{

    /**
     * The number of spaces code should be indented.
     *
     * @var int
     */
    public $indent = 4;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_EQUAL];

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
        $tokens = $phpcsFile->getTokens();

        // Equal sign can't be the last thing on the line.
        $next = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
        if ($next === false) {
            // Bad assignment.
            return;
        }

        if ($tokens[$next]['line'] !== $tokens[$stackPtr]['line']) {
            $error = 'Multi-line assignments must have the equal sign on the second line';
            $phpcsFile->addError($error, $stackPtr, 'EqualSignLine');
            return;
        }

        // Make sure it is the first thing on the line, otherwise we ignore it.
        $prev = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), false, true);
        if ($prev === false) {
            // Bad assignment.
            return;
        }

        if ($tokens[$prev]['line'] === $tokens[$stackPtr]['line']) {
            return;
        }

        // Find the required indent based on the ident of the previous line.
        $assignmentIndent = 0;
        $prevLine         = $tokens[$prev]['line'];
        for ($i = ($prev - 1); $i >= 0; $i--) {
            if ($tokens[$i]['line'] !== $prevLine) {
                $i++;
                break;
            }
        }

        if ($tokens[$i]['code'] === T_WHITESPACE) {
            $assignmentIndent = $tokens[$i]['length'];
        }

        // Find the actual indent.
        $prev = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1));

        $expectedIndent = ($assignmentIndent + $this->indent);
        $foundIndent    = $tokens[$prev]['length'];
        if ($foundIndent !== $expectedIndent) {
            $error = 'Multi-line assignment not indented correctly; expected %s spaces but found %s';
            $data  = [
                $expectedIndent,
                $foundIndent,
            ];
            $phpcsFile->addError($error, $stackPtr, 'Indent', $data);
        }

    }//end process()


}//end class
