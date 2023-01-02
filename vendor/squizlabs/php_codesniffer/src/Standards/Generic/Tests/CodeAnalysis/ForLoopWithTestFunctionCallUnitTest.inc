<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ForLoopWithTestFunctionCallUnitTest.inc
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

$a = array(1, 2, 3, 4);
for ($i = 0; $i < count($a); $i++) {
    $a[$i] *= $i;
}

for ($i = 0, $c = sizeof($a); $i < $c; ++$i) {
    $a[$i] *= $i;
}

$it = new ArrayIterator($a);
for ($it->rewind(); $it->valid(); $it->next()) {
    echo $it->current();
}