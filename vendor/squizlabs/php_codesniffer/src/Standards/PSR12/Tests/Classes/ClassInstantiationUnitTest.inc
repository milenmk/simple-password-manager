<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ClassInstantiationUnitTest.inc
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

$foo = new Foo();
$foo = new Foo();
$foo = new Foo\Bar();
$foo = new Foo\Bar();
$foo = new Foo /* comment */ ();

$foo = new $foo();
$foo = new $foo();
$foo = new $$foo();
$foo = new $$foo();

$foo = new self();
$foo = new self();
$foo = new static();
$foo = new static();

foo(new class {});
echo (new Foo())->bar();
echo (new Foo())->bar();
echo (new Foo((new Bar())->getBaz()))->bar();
$foo = (new Foo())::$bar;

echo (new Foo((new Bar()//comment
)->getBaz(new Baz() /* comment */)))->bar();

$foo = new $bar['a']();
$foo = new $bar['a']['b']();
$foo = new $bar['a'][$baz['a']['b']]['b']();
$foo = new $bar['a'] [$baz['a']/* comment */ ['b']]['b']();

$a = new self::$transport[$cap_string]();
$renderer = new $this->inline_diff_renderer();
$a = new ${$varHoldingClassName}();

$class = new $obj?->classname();
$class = new $obj?->classname();
$class = new ${$obj?->classname}();

// Issue 3456.
// Anon classes should be skipped, even when there is an attribute between the new and the class keywords.
$anonWithAttribute = new #[SomeAttribute('summary')] class {
    public const SOME_STUFF = 'foo';
};
