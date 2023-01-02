<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DuplicateStyleDefinitionSniff.php
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
 * Check for duplicate style definitions in the same class.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Sniffs\CSS;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DuplicateStyleDefinitionSniff implements Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = ['CSS'];


    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return int[]
     */
    public function register()
    {
        return [T_OPEN_CURLY_BRACKET];

    }//end register()


    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param File $phpcsFile                        The file where the token was found.
     * @param int  $stackPtr                         The position in the stack where
     *                                               the token was found.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]['bracket_closer']) === false) {
            // Syntax error or live coding, bow out.
            return;
        }

        // Find the content of each style definition name.
        $styleNames = [];

        $next = $stackPtr;
        $end  = $tokens[$stackPtr]['bracket_closer'];

        do {
            $next = $phpcsFile->findNext([T_STYLE, T_OPEN_CURLY_BRACKET], ($next + 1), $end);
            if ($next === false) {
                // Class definition is empty.
                break;
            }

            if ($tokens[$next]['code'] === T_OPEN_CURLY_BRACKET) {
                $next = $tokens[$next]['bracket_closer'];
                continue;
            }

            $name = $tokens[$next]['content'];
            if (isset($styleNames[$name]) === true) {
                $first = $styleNames[$name];
                $error = 'Duplicate style definition found; first defined on line %s';
                $data  = [$tokens[$first]['line']];
                $phpcsFile->addError($error, $next, 'Found', $data);
            } else {
                $styleNames[$name] = $next;
            }
        } while ($next !== false);

    }//end process()


}//end class
