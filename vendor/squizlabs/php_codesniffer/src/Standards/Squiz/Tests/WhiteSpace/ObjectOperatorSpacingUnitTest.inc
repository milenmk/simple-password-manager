<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ObjectOperatorSpacingUnitTest.inc
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

$this->testThis();
$this-> testThis();
$this    ->  testThis();
$this-> /* comment here */testThis();
$this/* comment here */ -> testThis();
$this
    ->testThis();
$this->
    testThis();

// phpcs:set Squiz.WhiteSpace.ObjectOperatorSpacing ignoreNewlines true

$this->testThis();
$this-> testThis();
$this    ->  testThis();
$this->/* comment here */testThis();
$this/* comment here */ -> testThis();
$this
    ->testThis();
$this->
    testThis();

// phpcs:set Squiz.WhiteSpace.ObjectOperatorSpacing ignoreNewlines false

thisObject::testThis();
thisObject:: testThis();
thisObject    ::  testThis();
thisObject::/* comment here */testThis();
thisObject/* comment here */ :: testThis();
thisObject
    ::testThis();
thisObject::
    testThis();
	
// phpcs:set Squiz.WhiteSpace.ObjectOperatorSpacing ignoreNewlines true

thisObject::testThis();
thisObject:: testThis();
thisObject    ::  testThis();
thisObject::/* comment here */testThis();
thisObject/* comment here */ :: testThis();
thisObject
    ::testThis();
thisObject::
    testThis();

// phpcs:set Squiz.WhiteSpace.ObjectOperatorSpacing ignoreNewlines false

$this?->testThis();
$this?-> testThis();
$this    ?->  testThis();
