<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ForbiddenFunctionsUnitTest.inc
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

$size = sizeof($array);
$size = count($array);
delete($filepath);
unset($filepath);
$size = sizeof($array);
$size = \my\ns\sizeof('abc');($array);

// No errors thrown for class methods.
$size = MyClass::sizeof($array);
$size = MyClass::count($array);
MyClass::delete($filepath);
MyClass::unset($filepath);

$size = $class->sizeof($array);
$size = $class->count($array);
$class->delete($filepath);
$class->unset($filepath);

function delete() {}
function unset() {}
function sizeof() {}
function count() {}

trait DelProvider {
  public function delete() {
    //irrelevant
  }
}

class LeftSideTest {
    use DelProvider {
        delete as protected unsetter;
    }
}

class RightSideTest {
    use DelProvider {
        delete as delete;
    }
}

class RightSideVisTest {
    use DelProvider {
        delete as protected delete;
        DelProvider::delete insteadof delete;
    }
}

namespace Something\sizeof;
$var = new Sizeof();
class SizeOf implements Something {}

function mymodule_form_callback(SizeOf $sizeof) {
}

$size = $class?->sizeof($array);
