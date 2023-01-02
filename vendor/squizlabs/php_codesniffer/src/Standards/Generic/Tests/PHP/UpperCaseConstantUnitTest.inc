<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UpperCaseConstantUnitTest.inc
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

// True
function myFunction($arg1, $arg2=TRUE)
{
}
function myFunction($arg1, $arg2=true)
{
}
function myFunction($arg1, $arg2=True)
{
}

if ($variable === TRUE) { }
if ($variable === true) { }
if ($variable === True) { }


// False
function myFunction($arg1, $arg2=FALSE)
{
}
function myFunction($arg1, $arg2=false)
{
}
function myFunction($arg1, $arg2=False)
{
}

if ($variable === FALSE) { }
if ($variable === false) { }
if ($variable === False) { }


// Null
function myFunction($arg1, $arg2=NULL)
{
}
function myFunction($arg1, $arg2=null)
{
}
function myFunction($arg1, $arg2=Null)
{
}

if ($variable === NULL) { }
if ($variable === null) { }
if ($variable === Null) { }

$x = new stdClass();
$x->null = 7;

use Zend\Log\Writer\Null as NullWriter;
new NullWriter();

namespace False;

class True extends Null implements False {}

use True\Something;
use Something\True;
class MyClass
{
    public function myFunction()
    {
        $var = array('foo' => new True());
    }
}

$x = $f?false:TRUE;
$x = $f? false:TRUE;

class MyClass
{
    // Spice things up a little.
    public const true = false;
}

var_dump(MyClass::true);

function true() {}

// Issue #3332 - ignore type declarations, but not default values.
class TypedThings {

    public const MYCONST = false;

	public int|false $int = false;
	public Type|null $int = new MyObj(null);

	private function typed(int|false $param = null, Type|null $obj = new MyObj(false)) : string|false|null
	{
		if (true === false) {
			return null;
        }
    }
}

$cl = function (int|false $param = null, Type|null $obj = new MyObj(false)) : string|false|null {};
