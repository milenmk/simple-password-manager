<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ControlStructureSpacingUnitTest.inc
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

if ($something) {
}
foreach ($this as $that ) {
}
while (true) {
    for ($i = 0; $i < 10; $i++) {
    }
    if ($something) {
    }

    foreach ($this as $that) {
        do {
        } while ( true );

    }
}

if ($defaultPageDesign === 0
    && $defaultCascade === TRUE
    && $defaultChildDesign === 0
) {
    $settingsUpdated = FALSE;
}

foreach ( $blah as $var ) {
    if (  $blah    ) {
    }
}

if (
    $defaultPageDesign === 0
    && $defaultCascade === TRUE
    && $defaultChildDesign === 0
) {
    $settingsUpdated = FALSE;
}

if ( // comment
    $something
) {
}

while ( /* comment */
    true
) {
}

// phpcs:set PSR2.ControlStructures.ControlStructureSpacing requiredSpacesAfterOpen 1
// phpcs:set PSR2.ControlStructures.ControlStructureSpacing requiredSpacesBeforeClose 1
foreach ($something as $blah => $that) {}
foreach ( $something as $blah => $that ) {}
foreach (  $something as $blah => $that  ) {}
// phpcs:set PSR2.ControlStructures.ControlStructureSpacing requiredSpacesAfterOpen 0
// phpcs:set PSR2.ControlStructures.ControlStructureSpacing requiredSpacesBeforeClose 0

$binary = b'binary string';

if ($expr1
    && $expr2             ) {
}

if ($expr1
    && $expr2     /* comment */   ) {
}

if ($expr1
    && $expr2
    /* comment */   ) {
}

$r = match ($x) {};
$r = match ( $x ) {};

// phpcs:set PSR2.ControlStructures.ControlStructureSpacing requiredSpacesAfterOpen 1
// phpcs:set PSR2.ControlStructures.ControlStructureSpacing requiredSpacesBeforeClose 1
$r = match ($x) {};
$r = match ( $x ) {};
$r = match (  $x  ) {};
// phpcs:set PSR2.ControlStructures.ControlStructureSpacing requiredSpacesAfterOpen 0
// phpcs:set PSR2.ControlStructures.ControlStructureSpacing requiredSpacesBeforeClose 0
