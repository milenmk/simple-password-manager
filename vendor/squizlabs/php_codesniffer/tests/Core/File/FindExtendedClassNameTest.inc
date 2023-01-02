<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FindExtendedClassNameTest.inc
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

class testFECNClass {}

/* testExtendedClass */
class testFECNExtendedClass extends testFECNClass {}

/* testNamespacedClass */
class testFECNNamespacedClass extends testFECNClass
{}

/* testNonExtendedClass */
class testFECNNonExtendedClass {}

/* testInterface */
interface testFECNInterface {}

/* testInterfaceThatExtendsInterface */
interface testInterfaceThatExtendsInterface extends testFECNInterface{}

/* testInterfaceThatExtendsFQCNInterface */
interface testInterfaceThatExtendsFQCNInterface extends testFECNInterface
{}

/* testNestedExtendedClass */
class testFECNNestedExtendedClass {
	public function someMethod() {
		/* testNestedExtendedAnonClass */
		$anon = new class extends testFECNAnonClass {};
	}
}

/* testClassThatExtendsAndImplements */
class testFECNClassThatExtendsAndImplements extends testFECNClass implements InterfaceA, InterfaceB {}

/* testClassThatImplementsAndExtends */
class testFECNClassThatImplementsAndExtends implements InterfaceA, InterfaceB extends testFECNClass {}
