<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: SpreadOperatorSpacingAfterSniff.php
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
 * Verifies spacing between the spread operator and the variable/function call it applies to.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2019 Juliette Reinders Folmer. All rights reserved.
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

class SpreadOperatorSpacingAfterSniff implements Sniff
{

    /**
     * The number of spaces desired after a spread token.
     *
     * @var int
     */
    public $spacing = 0;

    /**
     * Allow newlines instead of spaces.
     *
     * @var bool
     */
    public $ignoreNewlines = false;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_ELLIPSIS];

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param File $phpcsFile                        The file being scanned.
     * @param int  $stackPtr                         The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens        = $phpcsFile->getTokens();
        $this->spacing = (int) $this->spacing;

        $nextNonEmpty = $phpcsFile->findNext(Tokens::$emptyTokens, ($stackPtr + 1), null, true);
        if ($nextNonEmpty === false) {
            return;
        }

        if ($this->ignoreNewlines === true
            && $tokens[$stackPtr]['line'] !== $tokens[$nextNonEmpty]['line']
        ) {
            $phpcsFile->recordMetric($stackPtr, 'Spacing after spread operator', 'newline');
            return;
        }

        if ($this->spacing === 0 && $nextNonEmpty === ($stackPtr + 1)) {
            $phpcsFile->recordMetric($stackPtr, 'Spacing after spread operator', 0);
            return;
        }

        $nextNonWhitespace = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
        if ($nextNonEmpty !== $nextNonWhitespace) {
            $error = 'Expected %s space(s) after the spread operator; comment found';
            $data  = [$this->spacing];
            $phpcsFile->addError($error, $stackPtr, 'CommentFound', $data);

            if ($tokens[($stackPtr + 1)]['code'] === T_WHITESPACE) {
                $phpcsFile->recordMetric($stackPtr, 'Spacing after spread operator', $tokens[($stackPtr + 1)]['length']);
            } else {
                $phpcsFile->recordMetric($stackPtr, 'Spacing after spread operator', 0);
            }

            return;
        }

        $found = 0;
        if ($tokens[$stackPtr]['line'] !== $tokens[$nextNonEmpty]['line']) {
            $found = 'newline';
        } else if ($tokens[($stackPtr + 1)]['code'] === T_WHITESPACE) {
            $found = $tokens[($stackPtr + 1)]['length'];
        }

        $phpcsFile->recordMetric($stackPtr, 'Spacing after spread operator', $found);

        if ($found === $this->spacing) {
            return;
        }

        $error = 'Expected %s space(s) after the spread operator; %s found';
        $data  = [
            $this->spacing,
            $found,
        ];

        $errorCode = 'TooMuchSpace';
        if ($this->spacing !== 0) {
            if ($found === 0) {
                $errorCode = 'NoSpace';
            } else if ($found !== 'newline' && $found < $this->spacing) {
                $errorCode = 'TooLittleSpace';
            }
        }

        $fix = $phpcsFile->addFixableError($error, $stackPtr, $errorCode, $data);

        if ($fix === true) {
            $padding = str_repeat(' ', $this->spacing);
            if ($found === 0) {
                $phpcsFile->fixer->addContent($stackPtr, $padding);
            } else {
                $phpcsFile->fixer->beginChangeset();
                $start = ($stackPtr + 1);

                if ($this->spacing > 0) {
                    $phpcsFile->fixer->replaceToken($start, $padding);
                    ++$start;
                }

                for ($i = $start; $i < $nextNonWhitespace; $i++) {
                    $phpcsFile->fixer->replaceToken($i, '');
                }

                $phpcsFile->fixer->endChangeset();
            }
        }

    }//end process()


}//end class
