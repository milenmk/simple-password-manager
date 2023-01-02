<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: LowerCaseKeywordSniff.php
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
 * Checks that all PHP keywords are lowercase.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Sniffs\PHP;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Common;
use PHP_CodeSniffer\Util\Tokens;

class LowerCaseKeywordSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        $targets  = Tokens::$contextSensitiveKeywords;
        $targets += [
            T_CLOSURE       => T_CLOSURE,
            T_EMPTY         => T_EMPTY,
            T_ENUM_CASE     => T_ENUM_CASE,
            T_EVAL          => T_EVAL,
            T_ISSET         => T_ISSET,
            T_MATCH_DEFAULT => T_MATCH_DEFAULT,
            T_PARENT        => T_PARENT,
            T_SELF          => T_SELF,
            T_UNSET         => T_UNSET,
        ];

        return $targets;

    }//end register()


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param File $phpcsFile                        The file being scanned.
     * @param int  $stackPtr                         The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens  = $phpcsFile->getTokens();
        $keyword = $tokens[$stackPtr]['content'];
        if (strtolower($keyword) !== $keyword) {
            if ($keyword === strtoupper($keyword)) {
                $phpcsFile->recordMetric($stackPtr, 'PHP keyword case', 'upper');
            } else {
                $phpcsFile->recordMetric($stackPtr, 'PHP keyword case', 'mixed');
            }

            $messageKeyword = Common::prepareForOutput($keyword);

            $error = 'PHP keywords must be lowercase; expected "%s" but found "%s"';
            $data  = [
                strtolower($messageKeyword),
                $messageKeyword,
            ];

            $fix = $phpcsFile->addFixableError($error, $stackPtr, 'Found', $data);
            if ($fix === true) {
                $phpcsFile->fixer->replaceToken($stackPtr, strtolower($keyword));
            }
        } else {
            $phpcsFile->recordMetric($stackPtr, 'PHP keyword case', 'lower');
        }//end if

    }//end process()


}//end class
