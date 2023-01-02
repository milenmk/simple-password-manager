<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UselessOverridingMethodUnitTest.inc
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

class FooBar {
    public function __construct($a, $b) {
        parent::__construct($a, $b);
    }
}

class BarFoo {
    public function __construct($a, $b) {
        parent::__construct($a, 'XML', $b);
    }
}

class Foo {
    public function export($a, $b = null) {
        return parent::export($a, $b);
    }
}

class Bar {
    public function export($a, $b = null) {
        return parent::export($a);
    }
}