<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: AssignmentInConditionUnitTest.inc
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

// OK.
if ($a === 123) {
} elseif ($a == 123) {
} elseif ($a !== 123) {
} elseif ($a != 123) {}

function abc( $a = 'default' ) {}
if (in_array( $a, array( 1 => 'a', 2 => 'b' ) ) ) {}

switch ( $a === $b ) {}
switch ( true ) {
	case $sample == 'something':
		break;
}

for ( $i = 0; $i == 100; $i++ ) {}
for ( $i = 0; $i >= 100; $i++ ) {}
for ( $i = 0; ; $i++ ) {}
for (;;) {}

do {
} while ( $sample == false );

while ( $sample === false ) {}

// Silly, but not an assignment.
if (123 = $a) {}
if (strtolower($b) = $b) {}
if (array( 1 => 'a', 2 => 'b' ) = $b) {}

if (SOME_CONSTANT = 123) {
} else if(self::SOME_CONSTANT -= 10) {}

if ( $a() = 123 ) {
} else if ( $b->something() = 123 ) {
} elseif ( $c::something() = 123 ) {}

switch ( true ) {
	case 'something' = $sample:
		break;
}

// Assignments in condition.
if ($a = 123) {
} elseif ($a = 'abc') {
} else if( $a += 10 ) {
} else if($a -= 10) {
} else if($a *= 10) {
} else if($a **= 10) {
} else if($a /= 10) {
} else if($a .= strtolower($b)) {
} else if($a %= SOME_CONSTANT) {
} else if($a &= 2) {
} else if($a |= 2) {
} else if($a ^= 2) {
} else if($a <<= 2) {
} else if($a >>= 2) {
} else if($a ??= $b) {
} elseif( $a = 'abc' && $b = 'def' ) {
} elseif(
    $a = 'abc'
	&& $a .= 'def'
) {}

if ($a[] = 123) {
} elseif ($a['something'] = 123) {
} elseif (self::$a = 123) {
} elseif (parent::$a *= 123) {
} elseif (static::$a = 123) {
} elseif (MyClass::$a .= 'abc') {
} else if( $this->something += 10 ) {}

switch ( $a = $b ) {}
switch ( true ) {
	case $sample = 'something':
		break;

	case $sample = 'something' && $a = $b:
		break;
}

for ( $i = 0; $i = 100; $i++ ) {}
for ( $i = 0; $i = 100 && $b = false; $i++ ) {}

do {
} while ( $sample = false );

while ( $sample = false ) {}

if ($a = 123) :
endif;

match ($a[0] = 123) {};
