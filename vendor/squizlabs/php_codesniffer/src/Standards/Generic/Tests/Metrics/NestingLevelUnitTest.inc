<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: NestingLevelUnitTest.inc
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

function nestingOne()
{
    if ($condition) {
        echo 'hi';
    }
}

function nestingFive()
{
    if ($condition) {
        echo 'hi';
        switch ($condition)
        {
            case '1':
                if ($condition === '1') {
                    if ($cond) {
                        echo 'hi';
                    }
                }
            break;
        }
    }
}

function nestingSix()
{
    if ($condition) {
        echo 'hi';
        switch ($condition)
        {
            case '1':
                if ($condition === '1') {
                    if ($cond) {
                        foreach ($conds as $cond) {
                            echo 'hi';
                        }
                    }
                }
            break;
        }
    }
}

function nestingTen()
{
    if ($condition) {
        echo 'hi';
        switch ($condition)
        {
            case '1':
                if ($condition === '1') {
                    if ($cond) {
                        switch ($cond) {
                            case '1':
                                if ($cond === '1') {
                                    foreach ($conds as $cond) {
                                        if ($cond === 'hi') {
                                            echo 'hi';
                                        }
                                    }
                                }
                            break;
                        }
                    }
                }
            break;
        }
    }
}

function nestingEleven()
{
    if ($condition) {
        echo 'hi';
        switch ($condition)
        {
            case '1':
                if ($condition === '1') {
                    if ($cond) {
                        switch ($cond) {
                            case '1':
                                if ($cond === '1') {
                                    foreach ($conds as $cond) {
                                        if ($cond === 'hi') {
                                            if ($cond !== 'bye') {
                                                echo 'hi';
                                            }
                                        }
                                    }
                                }
                            break;
                        }
                    }
                }
            break;
        }
    }
}

?>
