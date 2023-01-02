<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ClassFileNameUnitTest.inc
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


// Valid class name (matching filename).
class ClassFileNameUnitTest {}
interface ClassFileNameUnitTest {}
trait ClassFileNameUnitTest {}
enum ClassFileNameUnitTest {}
enum ClassFileNameUnitTest: int {}

// Invalid filename matching class name (case sensitive).
class classFileNameUnitTest {}
class classfilenameunittest {}
class CLASSFILENAMEUNITTEST {}
interface classFileNameUnitTest {}
interface classfilenameunittest {}
interface CLASSFILENAMEUNITTEST {}
trait classFileNameUnitTest {}
trait classfilenameunittest {}
trait CLASSFILENAMEUNITTEST {}
enum classFileNameUnitTest {}
enum classfilenameunittest {}
enum CLASSFILENAMEUNITTEST {}


// Invalid non-filename matching class names.
class CompletelyWrongClassName {}
class ClassFileNameUnitTestExtra {}
class ClassFileNameUnitTestInc {}
class ExtraClassFileNameUnitTest {}
interface CompletelyWrongClassName {}
interface ClassFileNameUnitTestExtra {}
interface ClassFileNameUnitTestInc {}
interface ExtraClassFileNameUnitTest {}
trait CompletelyWrongClassName {}
trait ClassFileNameUnitTestExtra {}
trait ClassFileNameUnitTestInc {}
trait ExtraClassFileNameUnitTest {}
enum CompletelyWrongClassName {}
enum ClassFileNameUnitTestExtra {}
enum ClassFileNameUnitTestInc {}
enum ExtraClassFileNameUnitTest {}


?>
