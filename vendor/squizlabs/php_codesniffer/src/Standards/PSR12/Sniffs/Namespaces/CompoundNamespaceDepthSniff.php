<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: CompoundNamespaceDepthSniff.php
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
 * Verifies that compound namespaces are not defined too deep.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PSR12\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CompoundNamespaceDepthSniff implements Sniff
{

    /**
     * The max depth for compound namespaces.
     *
     * @var int
     */
    public $maxDepth = 2;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_OPEN_USE_GROUP];

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param File $phpcsFile                        The file being scanned.
     * @param int  $stackPtr                         The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $this->maxDepth = (int) $this->maxDepth;

        $tokens = $phpcsFile->getTokens();

        $end = $phpcsFile->findNext(T_CLOSE_USE_GROUP, ($stackPtr + 1));
        if ($end === false) {
            return;
        }

        $depth = 1;
        for ($i = ($stackPtr + 1); $i <= $end; $i++) {
            if ($tokens[$i]['code'] === T_NS_SEPARATOR) {
                $depth++;
                continue;
            }

            if ($i === $end || $tokens[$i]['code'] === T_COMMA) {
                // End of a namespace.
                if ($depth > $this->maxDepth) {
                    $error = 'Compound namespaces cannot have a depth more than %s';
                    $data  = [$this->maxDepth];
                    $phpcsFile->addError($error, $i, 'TooDeep', $data);
                }

                $depth = 1;
            }
        }

    }//end process()


}//end class
