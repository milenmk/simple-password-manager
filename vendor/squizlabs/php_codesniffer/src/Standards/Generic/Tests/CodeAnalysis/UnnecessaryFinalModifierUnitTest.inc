<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UnnecessaryFinalModifierUnitTest.inc
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
    final public function fooBar() {}
    final protected function fool() {}
    final private function Bar() {}
}

final class Foo_Bar {
    public       $foobar;
    final public $FOOBAR = 23; // Parse error, but that's not the concern of this sniff, so report it.
    final public function fooBar() {}

    protected function foo() {}
    final protected function fool() {}

    private function Bar() {}
    final private function Bard() {}
}

final class Bar_Foo {
    public $foobar;
    protected $foo;
    private $bar;

    public function fooBar() {}
    protected function foo() {}
    private function Bar() {}
}
