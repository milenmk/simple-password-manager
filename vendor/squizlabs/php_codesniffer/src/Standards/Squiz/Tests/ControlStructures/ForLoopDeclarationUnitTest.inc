<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ForLoopDeclarationUnitTest.inc
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
for ($i = 0; $i < 10; $i++) {
}

// Invalid.
for ( $i = 0; $i < 10; $i++ ) {
}

for ($i = 0;  $i < 10;  $i++) {
}

for ($i = 0 ; $i < 10 ; $i++) {
}

for ($i = 0;$i < 10;$i++) {
}

// The works.
for ( $i = 0 ;  $i < 10 ;  $i++ ) {
}

for ($i = 0; $i < 10;) {
}

for ($i = 0; $i < 10; ) {
}

for ($i = 0; ; $i++) {
}
for ($i = 0;; $i++) {
}

// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesAfterOpen 1
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesBeforeClose 1
for ($i = 0; $i < 10; $i++) {}
for ( $i = 0; $i < 10; $i++ ) {}
for (  $i = 0; $i < 10; $i++  ) {}
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesAfterOpen 0
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesBeforeClose 0

for (         ; $i < 10; $i++) {}
for (; $i < 10; $i++) {}

// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesAfterOpen 1
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesBeforeClose 1
for ( ; $i < 10; $i++ ) {}
for (         ; $i < 10; $i++ ) {}
for (; $i < 10; $i++ ) {}

for ( $i = 0; $i < 10; ) {}
for ( $i = 0; $i < 10;) {}
for ( $i = 0; $i < 10;     ) {}
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesAfterOpen 0
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesBeforeClose 0

// Test handling of comments and inline annotations.
for ( /*phpcs:enable*/ $i = 0 /*start*/ ;    /*end*/$i < 10/*comment*/; $i++ /*comment*/   ) {}

// Test multi-line FOR control structure.
for (
    $i = 0;
    $i < 10;
    $i++
) {}

// Test multi-line FOR control structure with comments and annotations.
for (
    $i = 0; /* Start */
    $i < 10; /* phpcs:ignore Standard.Category.SniffName -- for reasons. */
    $i++ // comment

) {}

// Test fixing each error in one go. Note: lines 78 + 82 contain trailing whitespace on purpose.
for (
      

      $i = 0

      ; 

      $i < 10

      ;

      $i++


) {}

// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesAfterOpen 1
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesBeforeClose 1
for (



      $i = 0

      ;

      $i < 10

      ;

      $i++


) {}
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesAfterOpen 0
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration requiredSpacesBeforeClose 0

// Test with semi-colon not belonging to for.
for ($i = function() { return $this->i  ;    }; $i < function() { return $this->max; }; $i++) {}
for ($i = function() { return $this->i; }; $i < function() { return $this->max; }  ;   $i++) {}

// phpcs:set Squiz.ControlStructures.ForLoopDeclaration ignoreNewlines true
for (
    $i = 0;
    $i < 5;
    $i++
) {
    // body here
}
// phpcs:set Squiz.ControlStructures.ForLoopDeclaration ignoreNewlines false

// This test has to be the last one in the file! Intentional parse error check.
for
