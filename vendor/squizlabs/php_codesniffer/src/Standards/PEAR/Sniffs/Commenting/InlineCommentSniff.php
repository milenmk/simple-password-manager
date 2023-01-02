<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: InlineCommentSniff.php
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
 * Checks that no Perl-style comments are used.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PEAR\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class InlineCommentSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_COMMENT];

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

        if ($tokens[$stackPtr]['content'][0] === '#') {
            $phpcsFile->recordMetric($stackPtr, 'Inline comment style', '# ...');

            $error  = 'Perl-style comments are not allowed. Use "// Comment."';
            $error .= ' or "/* comment */" instead.';
            $fix    = $phpcsFile->addFixableError($error, $stackPtr, 'WrongStyle');
            if ($fix === true) {
                $newComment = ltrim($tokens[$stackPtr]['content'], '# ');
                $newComment = '// '.$newComment;
                $phpcsFile->fixer->replaceToken($stackPtr, $newComment);
            }
        } else if ($tokens[$stackPtr]['content'][0] === '/'
            && $tokens[$stackPtr]['content'][1] === '/'
        ) {
            $phpcsFile->recordMetric($stackPtr, 'Inline comment style', '// ...');
        } else if ($tokens[$stackPtr]['content'][0] === '/'
            && $tokens[$stackPtr]['content'][1] === '*'
        ) {
            $phpcsFile->recordMetric($stackPtr, 'Inline comment style', '/* ... */');
        }

    }//end process()


}//end class
