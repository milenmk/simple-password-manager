<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: FunctionDeclarationUnitTest.inc
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

function someFunctionWithAVeryLongName($firstParameter='something',
   $secondParameter='booooo', $third=null, $fourthParameter=false,
     $fifthParameter=123.12, $sixthParam=true
){
}

function someFunctionWithAVeryLongName2($firstParameter='something',
$secondParameter='booooo', $third=null, $fourthParameter=false,
$fifthParameter=123.12, $sixthParam=true
)  {
}

function blah() {
}

function  blah()
{
}

abstract class MyClass
{

    public function someFunctionWithAVeryLongName($firstParameter='something',
        $secondParameter='booooo', $third=null, $fourthParameter=false,
        $fifthParameter=123.12, $sixthParam=true
    ) /** w00t */ {
    }

    public function someFunctionWithAVeryLongName2(
        $firstParameter='something', $secondParameter='booooo', $third=null
    ) {
    }

    abstract protected function processTokenWithinScope(
        PHP_CodeSniffer_File $phpcsFile,
        $stackPtr,
        $currScope
    );

    abstract protected function processToken(
        PHP_CodeSniffer_File $phpcsFile,
        $stackPtr,
        $currScope);

}

function getInstalledStandards(
    $includeGeneric=false,
    $standardsDir=''
)
{
}

function &testFunction($arg1,
    $arg2,
) {
}

function testFunction($arg1,
$arg2) {
}

function validateUrl(
    $url,
    $requireScheme=TRUE,
    array $allowedSchemes=array(
                           'http',
                           'https',
                          ),
    array $notAllowedSchemes=array('ftp', 'sftp')
) {
}

function validateUrlShort(
    $url,
    $requireScheme=TRUE,
    array $allowedSchemes=[
        'http',
        'https',
    ],
    array $notAllowedSchemes=['ftp', 'sftp']
) {
}

$noArgs_longVars = function () use (
    $longVar1,
    $longerVar2,
    $muchLongerVar3
) {
    // body
};

$longArgs_longVars = function (
    $longArgument,
    $longerArgument,
    $muchLongerArgument
) use  (
    $longVar1,
    $longerVar2,
    $muchLongerVar3
) {
    // body
};

$longArgs_longVars = function (
    $longArgument,
    $longerArgument,
    $muchLongerArgument
    )  use (
    $longVar1,
    $longerVar2,
    $muchLongerVar3
) {
    // body
};

$longArgs_longVars = function (
    $longArgument,
    $muchLongerArgument)use(
    $muchLongerVar3) {
    // body
};

function test()
{
    $longArgs_longVars = function (
        $longArgument,
        $longerArgument,
        $muchLongerArgument
    ) use (
        $longVar1,
        $longerVar2,
        $muchLongerVar3
    ) {
        // body
    };
}

function
    myFunction()
{
}

function
myFunction()
{
}


use function foo\bar;

use
    function bar\baz;

namespace {
    use function Name\Space\f;
    f();
}

$var = function() {return true;};
$var = function() {return true;
};
function blah(){return true;
}

$closureWithArgsAndVars = function($arg1, $arg2) use ($var1, $var2){
    // body
};

function
blah
()
{
    // body
}

$b = function &() {
    echo 'hello';
};

function foo(
    $param1,
    $param2,
    $param3
) : SomeClass {
}

function foo(
    $param1,
    $param2,
    $param3
): SomeClass {
}

function foo(
    $param1,
    $param2,
    $param3
): SomeClass // Comment here
{
}

function foo(
    $param1,

    $param2,

    $param3
) : SomeClass {
}

function foo(
    $var
)
{
    // body
}

function foo(
    $var
)
/* hello */ {
    // body
}

function foo(
    $var
)
{ echo 'hi';
    // body
}

function foo(
    $var
)
/* hello */ { echo 'hi';
    // body
}

$a = function () {

function foo ()
{}

abstract class Foo {

public function bar ()
    {
    }

public abstract function baz () ;

public abstract function qux () : void ;
}

interface Foo {

public function bar () ;

public function baz (
        $longArgument,
        $longerArgument,
        $muchLongerArgument
    ) ;

public function qux (
        $longArgument,
        $longerArgument,
        $muchLongerArgument
    ) : void ;
}

trait Foo {

public function bar ()
    {
    }

public abstract function baz ()
    ;
}

if(true) {
    abstract class Foo
    {

        public function bar() {}

        public abstract function baz();

        public abstract function qux(): void;

    }

    interface Foo
    {

        public function bar();

        public function baz(
            $longArgument,
            $longerArgument,
            $muchLongerArgument
        );

        public function qux(
            $longArgument,
            $longerArgument,
            $muchLongerArgument
        ): void;

    }

    trait Foo
    {

        public function bar() {}

        public abstract function baz();

    }
}

class ConstructorPropertyPromotionSingleLineDocblockIndentOK
{
    public function __construct(
        /** @var string */
        public string $public,
        /** @var string */
        private string $private,
    ) {
    }
}

class ConstructorPropertyPromotionMultiLineDocblockAndAttributeIndentOK
{
    public function __construct(
        /**
         * @var string
         * @Assert\NotBlank()
         */
        public string $public,
        /**
         * @var string
         * @Assert\NotBlank()
         */
        #[NotBlank]
        private string $private,
    ) {
    }
}

class ConstructorPropertyPromotionSingleLineDocblockIncorrectIndent
{
    public function __construct(
      /** @var string */
      public string $public,
          /** @var string */
          private string $private,
    ) {
    }
}

class ConstructorPropertyPromotionMultiLineDocblockAndAttributeIncorrectIndent
{
    public function __construct(
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $public,
/**
 * @var string
 * @Assert\NotBlank()
 */
#[NotBlank]
private string $private,
    ) {
    }
}

class ConstructorPropertyPromotionMultiLineAttributesOK
{
    public function __construct(
        #[ORM\ManyToOne(
            Something: true,
            SomethingElse: 'text',
        )]
        #[Groups([
            'ArrayEntry',
            'Another.ArrayEntry',
        ])]
        #[MoreGroups(
            [
                'ArrayEntry',
                'Another.ArrayEntry',
            ]
        )]
        private Type $property
    ) {
        // Do something.
    }
}

class ConstructorPropertyPromotionMultiLineAttributesIncorrectIndent
{
    public function __construct(
    #[ORM\ManyToOne(
        Something: true,
        SomethingElse: 'text',
    )]
            #[Groups([
                'ArrayEntry',
                'Another.ArrayEntry',
            ])]
        #[MoreGroups(
    [
        'ArrayEntry',
        'Another.ArrayEntry',
    ]
        )]
        private Type $property
    ) {
        // Do something.
    }
}
