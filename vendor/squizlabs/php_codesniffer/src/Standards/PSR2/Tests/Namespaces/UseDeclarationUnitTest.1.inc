<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UseDeclarationUnitTest.1.inc
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

namespace MyProject;

use BarClass as Bar;
use My\Full\Classname as Another;


use Something;
use SomethingElse;

// Comment here.
use LastThing;

class Foo {
}

$var = new MyClass(
    function () use ($foo, $bar) {
        return true;
    }
);

class Container extends Component implements IContainer
{
    use TContainer;
}

trait HelloWorld
{

    use Hello;
    use World;
}

enum SomeEnum
{

    use Hello;
    use World;
}

$x = $foo ? function ($foo) use /* comment */ ($bar): int {
    return 1;
} : $bar;

// Testcase must be on last line in the file.
use
