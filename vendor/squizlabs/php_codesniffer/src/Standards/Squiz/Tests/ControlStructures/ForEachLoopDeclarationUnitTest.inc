<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ForEachLoopDeclarationUnitTest.inc
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

// Valid.
foreach ($something as $blah => $that) {
}

// Invalid.
foreach ( $something as $blah => $that ) {
}

foreach ($something   as   $blah => $that) {
}

foreach ($something as $blah   =>  $that) {
}

foreach (${something}AS$blah=>$that) {
}

// The works.
foreach (  $something   aS   $blah    =>   $that   ) {
}

// phpcs:set Squiz.ControlStructures.ForEachLoopDeclaration requiredSpacesAfterOpen 1
// phpcs:set Squiz.ControlStructures.ForEachLoopDeclaration requiredSpacesBeforeClose 1
foreach ($something as $blah => $that) {}
foreach ( $something as $blah => $that ) {}
foreach (  $something as $blah => $that  ) {}
// phpcs:set Squiz.ControlStructures.ForEachLoopDeclaration requiredSpacesAfterOpen 0
// phpcs:set Squiz.ControlStructures.ForEachLoopDeclaration requiredSpacesBeforeClose 0

foreach ([
          'foo'    => 'bar',
          'foobaz' => 'bazzy',
         ] as $key => $value) {
}
