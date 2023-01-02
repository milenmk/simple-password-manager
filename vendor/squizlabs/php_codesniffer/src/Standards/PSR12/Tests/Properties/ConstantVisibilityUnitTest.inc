<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ConstantVisibilityUnitTest.inc
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

class Foo {
    public const BAR = 'bar';
    public const BAZ = 'baz';
}

const APPLICATION_ENV = 'development';

// Issue 3526, PHP 8.1 final constants.
class SampleEnum
{
    final const FOO = 'SAMPLE';

    final public const BAR = 'SAMPLE';

    final private const BAZ = 'SAMPLE';
}

enum SomeEnum {
    public const BAR = 'bar';
    public const BAZ = 'baz';
}
