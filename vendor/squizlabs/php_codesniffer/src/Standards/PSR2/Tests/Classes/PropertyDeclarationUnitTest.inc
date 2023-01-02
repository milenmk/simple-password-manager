<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: PropertyDeclarationUnitTest.inc
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

class MyClass
{
    public $var = null;
    protected $var = null;
    private $var = null;
    $var = null;

    public        $var = null;
    static public $var = null;
    public        $var = null; // Parse error.

    public $_var = null;
    protected $_var = null;
    private $_var = null;

    public $foo, $bar, $var = null;
    public $foo,
           $bar,
           $var = null;

    protected
        $foo,
        $bar;
}

class foo
{

    public const bar = <<<BAZ
qux
BAZ;
}

class ABC {
    public static $propA;
    protected static $propB;
    private static $propC;
    public static  $propD;
    protected static
                   $propE;
    private static    /*comment*/$propF;
}

class MyClass
{
    public string $var = null;
    protected ?Folder\ClassName $var = null;

    public int $var = null;
    static int $var = null;

    private int $_var = null;

    public $foo, $bar, $var = null;
    public ?string $foo,
           $bar,
           $var = null;

    protected
    array
        $foo,
        $bar;
}

class MyClass
{
    public string$var = null;
    protected ?Folder\ClassName
        $var = null;
    public int   $var = null;
    public static int/*comment*/$var = null;
}

class ReadOnlyProp {
    public readonly int $foo,
        $bar,
        $var = null;

    protected readonly ?string    $foo;

    readonly array $foo;
}
