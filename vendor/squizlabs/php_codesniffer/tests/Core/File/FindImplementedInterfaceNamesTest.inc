<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FindImplementedInterfaceNamesTest.inc
 *  Last Modified: 3.01.23 г., 0:06 ч.
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

namespace PHP_CodeSniffer\Tests\Core\File;

use Deck;
use InterfaceA;
use NameSpaced\Cat\InterfaceB;

interface testFIINInterface2 {}

/* testInterface */
interface testFIINInterface {}

/* testImplementedClass */
class testFIINImplementedClass implements testFIINInterface {}

/* testMultiImplementedClass */
class testFIINMultiImplementedClass implements testFIINInterface, testFIINInterface2 {}

/* testNamespacedClass */
class testFIINNamespacedClass implements testFIINInterface
{}

/* testNonImplementedClass */
class testFIINNonImplementedClass {}

/* testClassThatExtendsAndImplements */
class testFECNClassThatExtendsAndImplements extends testFECNClass implements InterfaceA, InterfaceB {}

/* testClassThatImplementsAndExtends */
class testFECNClassThatImplementsAndExtends implements InterfaceA, InterfaceB extends testFECNClass {}

/* testBackedEnumWithoutImplements */
enum Suit:string {}

/* testEnumImplements */
enum Suit implements Colorful {}

/* testBackedEnumImplements */
enum Suit: string implements Colorful, Deck {}
