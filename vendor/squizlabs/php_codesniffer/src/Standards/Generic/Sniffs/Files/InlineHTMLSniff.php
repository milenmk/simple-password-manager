<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: InlineHTMLSniff.php
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
 * Ensures the whole file is PHP only, with no whitespace or inline HTML.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Sniffs\Files;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class InlineHTMLSniff implements Sniff
{

    /**
     * List of supported BOM definitions.
     *
     * Use encoding names as keys and hex BOM representations as values.
     *
     * @var array
     */
    protected $bomDefinitions = [
        'UTF-8'       => 'efbbbf',
        'UTF-16 (BE)' => 'feff',
        'UTF-16 (LE)' => 'fffe',
    ];


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_INLINE_HTML];

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param File $phpcsFile                        The file being scanned.
     * @param int  $stackPtr                         The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return int|null
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        // Allow a byte-order mark.
        $tokens = $phpcsFile->getTokens();
        foreach ($this->bomDefinitions as $bomName => $expectedBomHex) {
            $bomByteLength = (strlen($expectedBomHex) / 2);
            $htmlBomHex    = bin2hex(substr($tokens[0]['content'], 0, $bomByteLength));
            if ($htmlBomHex === $expectedBomHex && strlen($tokens[0]['content']) === $bomByteLength) {
                return;
            }
        }

        // Ignore shebang lines.
        $tokens = $phpcsFile->getTokens();
        if (substr($tokens[$stackPtr]['content'], 0, 2) === '#!') {
            return;
        }

        $error = 'PHP files must only contain PHP code';
        $phpcsFile->addError($error, $stackPtr, 'Found');

        return $phpcsFile->numTokens;

    }//end process()


}//end class
