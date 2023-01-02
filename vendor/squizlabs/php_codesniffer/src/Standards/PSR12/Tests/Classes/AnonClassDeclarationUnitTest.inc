<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: AnonClassDeclarationUnitTest.inc
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

$instance1 = new class extends Foo implements HandleableInterface {
};

$instance2 = new class extends Foo implements
    ArrayAccess,
    Countable,
    Serializable
{
};

$instance3 = new class {
};
$instance4 = new class ($arg) {
};

$instance5 = new class
{

};

$instance6 = new class {

};

// Bad

$instance1 = new class( $arg )

{};
$instance2 = new class   ($one ,  $two ) {};
$instance3 = new class(


    $one ,
$two,
  $three, $four) {};

$instance4 = new class
            extends Foo {
            };

$instance5 = new class($one ,
  $two , $three) extends Foo
    implements HandleableInterface {};

$instance6 = new class extends Foo
    implements HandleableInterface {
    // Class content
};

$instance7 = new  class  extends Foo implements
    One, Two,
    Three,
    Four,
    Five {
    // Class content
};

if ($foo) {
    $instance8 = new class extends Foo implements
        One,
        Five {
        // Class content
    };
}

$instance9 = new class (
    $one,
    $two
) extends Foo implements One {
    // Class content
};

$instance10 = new class   {};

$foo->bar(
    new class implements Bar {
        // ...
    },
);

foo(new class {
});
