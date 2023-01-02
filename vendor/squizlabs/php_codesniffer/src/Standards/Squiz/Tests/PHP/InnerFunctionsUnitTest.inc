<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: InnerFunctionsUnitTest.inc
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

function outer()
{
    if (!function_exists('inner')) {
        function inner() {
        }
    }
}

// Closures are allowed.
function myFunc($foo)
{
    $callback = function ($bar) use ($foo)
                {
                    $bar += $foo;
                };
}

// Anon class methods are allowed.
function test()
{
    return new class {

        public function foo()
        {
            // do something
        }
    };
}

new class {
    public function valueObject(): object
    {
         return new class {
            public function string(): string {
                 return 'string';
            }
        };
    }
};

new class {
    public function outer()
    {
        if (!function_exists('inner')) {
            function inner() {
            }
        }
    }
};
