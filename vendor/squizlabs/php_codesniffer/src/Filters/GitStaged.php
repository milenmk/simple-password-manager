<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: GitStaged.php
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
 * A filter to only include files that have been staged for commit in a Git repository.
 *
 * This filter is the ideal companion for your pre-commit git hook.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2018 Juliette Reinders Folmer. All rights reserved.
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Filters;

use PHP_CodeSniffer\Util;

class GitStaged extends ExactMatch
{


    /**
     * Get a list of blacklisted file paths.
     *
     * @return array
     */
    protected function getBlacklist()
    {
        return [];

    }//end getBlacklist()


    /**
     * Get a list of whitelisted file paths.
     *
     * @return array
     */
    protected function getWhitelist()
    {
        $modified = [];

        $cmd    = 'git diff --cached --name-only -- '.escapeshellarg($this->basedir);
        $output = [];
        exec($cmd, $output);

        $basedir = $this->basedir;
        if (is_dir($basedir) === false) {
            $basedir = dirname($basedir);
        }

        foreach ($output as $path) {
            $path = Util\Common::realpath($path);
            if ($path === false) {
                // Skip deleted files.
                continue;
            }

            do {
                $modified[$path] = true;
                $path            = dirname($path);
            } while ($path !== $basedir);
        }

        return $modified;

    }//end getWhitelist()


}//end class
