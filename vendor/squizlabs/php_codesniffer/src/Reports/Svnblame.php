<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Svnblame.php
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
 * SVN blame report for PHP_CodeSniffer.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Reports;

use PHP_CodeSniffer\Exceptions\DeepExitException;

class Svnblame extends VersionControl
{

    /**
     * The name of the report we want in the output
     *
     * @var string
     */
    protected $reportName = 'SVN';


    /**
     * Extract the author from a blame line.
     *
     * @param string $line Line to parse.
     *
     * @return mixed string or false if impossible to recover.
     */
    protected function getAuthor($line)
    {
        $blameParts = [];
        preg_match('|\s*([^\s]+)\s+([^\s]+)|', $line, $blameParts);

        if (isset($blameParts[2]) === false) {
            return false;
        }

        return $blameParts[2];

    }//end getAuthor()


    /**
     * Gets the blame output.
     *
     * @param string $filename File to blame.
     *
     * @return array
     * @throws DeepExitException
     */
    protected function getBlameContent($filename)
    {
        $command = 'svn blame "'.$filename.'" 2>&1';
        $handle  = popen($command, 'r');
        if ($handle === false) {
            $error = 'ERROR: Could not execute "'.$command.'"'.PHP_EOL.PHP_EOL;
            throw new DeepExitException($error, 3);
        }

        $rawContent = stream_get_contents($handle);
        pclose($handle);

        $blames = explode("\n", $rawContent);

        return $blames;

    }//end getBlameContent()


}//end class
