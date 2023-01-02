<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ValidVariableNameUnitTest.inc
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
    public $varName  = 'hello';
    public $var_name = 'hello';
    public $varname  = 'hello';
    public $_varName = 'hello';

    public $varName  = 'hello';
    public $var_name = 'hello';
    public $varname  = 'hello';
    public $_varName = 'hello';

    protected $varName  = 'hello';
    protected $var_name = 'hello';
    protected $varname  = 'hello';
    protected $_varName = 'hello';

    private $_varName  = 'hello';
    private $_var_name = 'hello';
    private $_varname  = 'hello';
    private $varName   = 'hello';
}

class MyClass
{

    public function func1()
    {

        function func2()
        {

            return $a;
        }

        return $data;
    }

}

class MyClass
{
    public function prepare() {}
    public function paint() {}
}

if (true) {
    class MyClass
    {
        public $varName  = 'hello';
        public $var_name = 'hello';
    }
}

class MyClass
{

    public function myFunction($cc, $cv)
    {

        $req = "delete from blah
                where not (POP_{$cc}_A =
'{$this->def["POP_{$cc}_A"]}'
                         and POP_{$cc}_B =
'{$this->def["POP_{$cc}_B"]}')";
    }

}

class mpgResponse
{

    public $term_id;
    public $currentTag;

    public function characterHandler($parser, $data)
    {

        switch ($this->currentTag) {
            case 'term_id':
            {
                $this->term_id = $data;
                break;
            }
        }
    }//end characterHandler

}//end class mpgResponse

class foo
{

    public const bar = <<<BAZ
qux
BAZ;
}

class foo
{
    public $c = <<<C
ccc
C;
}

class a
{
    protected
        $_sheet,
        $_FieldParser,
        $_key;
}

$util->setLogger(
    new class {
        private $varName  = 'hello';
        private $_varName = 'hello';
});
