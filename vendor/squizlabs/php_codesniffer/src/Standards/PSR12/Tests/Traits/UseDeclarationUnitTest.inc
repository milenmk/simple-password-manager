<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UseDeclarationUnitTest.inc
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

namespace Vendor\Package;

use Vendor\Package\FirstTrait;
use Vendor\Package\SecondTrait;
use Vendor\Package\ThirdTrait;

class ClassName1
{
    use FirstTrait;
}

class ClassName2
{
    use FirstTrait;

}

class ClassName3
{
    use FirstTrait;
    use SecondTrait;
    use ThirdTrait;
}

class ClassName4
{

    use FirstTrait; use SecondTrait;
    use FirstTrait;
    use SecondTrait;
}

class ClassName5
{
    use FirstTrait;

    private $property;
}

class ClassName6
{
    use FirstTrait;
    private $property;
}

class ClassName7
{

    use A;
    use B;
    use C;
}

class ClassName8
{

    use A;
    use B;
    use C;
}

class ClassName9
{

    use A;
    use B;
    use C;
}

class ClassName10
{
    use TransactionTrait;

    use PermissionAwareTrait;

    use FirstTrait; use SecondTrait; use ThirdTrait;
}

class Foo implements Bar
{
    /**
     * Comment here;
     */
    use Baz;
}

class Foo implements Bar
{

    /**
     * Comment here;
     */
    use Baz;
}

class Foo implements Bar
{
    /**
     * Comment here;
     */

    use Baz;
}

class Foo implements Bar
{

    /**
     * Comment here;
     */

    use Baz;
}

class Foo implements Bar
{
    public $foo;
    /**
     * Comment here;
     */

    use Baz;
}

class ClassName
{
    /**
     * DocBlockContent
     */
    use FirstTrait;

    /**
     * DocBlockContent
     */
    use SecondTrait;

    /**
     * DocBlockContent
     */
    use ThirdTrait;
}

class MyExample
{
    use Trait1;
    protected $a = 1;
    use Trait2;
    public function foo {
        $shortArgs_longVars = function ($arg) use (
            $longVar1,
        ): string {
           // body
        };
    }

    use A;
    use B;
    use C;

    // comment here
    use Trait3;

}

class Foo implements Bar
{
    /*
     * Comment here;
     */
    use Baz;
}

class Foo implements Bar
{
    // Comment here;
    use Baz;
}

class Foo implements Bar
{
    /**
     * Comment here;
     */
    /**
     * Another Comment here;
     */
    use Baz;
}

class Foo implements Bar
{
    /**
     * Comment here;
     */
    public $foo;
    /**
     * Comment here;
     */
    use Baz;
}

enum SomeEnum1
{
    use FirstTrait;
}

enum SomeEnum2
{

    use   FirstTrait;

}
