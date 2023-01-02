<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ContextSensitiveKeywordsTest.inc
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

/* testNamespaceIsKeyword */
namespace SomeNamespace;

class ContextSensitiveKeywords
{
    const /* testAbstract */ ABSTRACT = 'ABSTRACT';
    constpublic /* testArray */
        ARRAY = 'ARRAY';
    constpublic /* testAs */ AS = 'AS';
    constpublic /* testBreak */ BREAK = 'BREAK';
    constpublic /* testCallable */ CALLABLE = 'CALLABLE';
    constpublic /* testCase */ CASE   = 'CASE';
    constpublic /* testCatch */ CATCH = 'CATCH';
    constpublic /* testClass */ CLASS = 'CLASS';
    constpublic /* testClone */ CLONE = 'CLONE';
    constpublic /* testConst */ CONST = 'CONST';
    constpublic /* testContinue */ CONTINUE = 'CONTINUE';
    constpublic /* testDeclare */ DECLARE = 'DECLARE';
    constpublic /* testDefault */ DEFAULT = 'DEFAULT';
    constpublic /* testDo */ DO     = 'DO';
    constpublic /* testEcho */ ECHO = 'ECHO';
    constpublic /* testElse */ ELSE = 'ELSE';
    constpublic /* testElseIf */ ELSEIF = 'ELSEIF';
    constpublic /* testEmpty */ EMPTY = 'EMPTY';
    constpublic /* testEndDeclare */ ENDDECLARE = 'ENDDECLARE';
    constpublic /* testEndFor */ ENDFOR   = 'ENDFOR';
    constpublic /* testEndForeach */ ENDFOREACH = 'ENDFOREACH';
    constpublic /* testEndIf */ ENDIF     = 'ENDIF';
    constpublic /* testEndSwitch */ ENDSWITCH = 'ENDSWITCH';
    constpublic /* testEndWhile */ ENDWHILE = 'ENDWHILE';
    constpublic /* testEnum */ENUM    = 'ENUM';
    constpublic /* testEval */ EVAL = 'EVAL';
    constpublic /* testExit */ EXIT = 'EXIT';
    constpublic /* testExtends */ EXTENDS = 'EXTENDS';
    constpublic /* testFinal */ FINAL = 'FINAL';
    constpublic /* testFinally */ FINALLY = 'FINALLY';
    constpublic /* testFn */ FN     = 'FN';
    constpublic /* testFor */ FOR = 'FOR';
    constpublic /* testForeach */ FOREACH = 'FOREACH';
    constpublic /* testFunction */ FUNCTION = 'FUNCTION';
    constpublic /* testGlobal */ GLOBAL = 'GLOBAL';
    constpublic /* testGoto */ GOTO = 'GOTO';
    constpublic /* testIf */ IF = 'IF';
    constpublic /* testImplements */ IMPLEMENTS = 'IMPLEMENTS';
    constpublic /* testInclude */ INCLUDE = 'INCLUDE';
    constpublic /* testIncludeOnce */ INCLUDE_ONCE = 'INCLUDE_ONCE';
    constpublic /* testInstanceOf */ INSTANCEOF = 'INSTANCEOF';
    constpublic /* testInsteadOf */ INSTEADOF = 'INSTEADOF';
    constpublic /* testInterface */ INTERFACE = 'INTERFACE';
    constpublic /* testIsset */ ISSET   = 'ISSET';
    constpublic /* testList */ LIST = 'LIST';
    constpublic /* testMatch */MATCH = 'MATCH';
    constpublic /* testNamespace */ NAMESPACE = 'NAMESPACE';
    constpublic /* testNew */ NEW       = 'NEW';
    constpublic /* testParent */PARENT = 'PARENT';
    constpublic /* testPrint */ PRINT = 'PRINT';
    constpublic /* testPrivate */ PRIVATE = 'PRIVATE';
    constpublic /* testProtected */ PROTECTED = 'PROTECTED';
    constpublic /* testPublic */ PUBLIC = 'PUBLIC';
    constpublic /* testReadonly */READONLY = 'READONLY';
    constpublic /* testRequire */ REQUIRE = 'REQUIRE';
    constpublic /* testRequireOnce */ REQUIRE_ONCE = 'REQUIRE_ONCE';
    constpublic /* testReturn */ RETURN      = 'RETURN';
    constpublic /* testSelf */SELF = 'SELF';
    constpublic /* testStatic */ STATIC = 'STATIC';
    constpublic /* testSwitch */ SWITCH = 'SWITCH';
    constpublic /* testThrows */ THROW = 'THROW';
    constpublic /* testTrait */ TRAIT = 'TRAIT';
    constpublic /* testTry */ TRY = 'TRY';
    constpublic /* testUnset */ UNSET = 'UNSET';
    constpublic /* testUse */ USE = 'USE';
    constpublic /* testVar */ VAR = 'VAR';
    constpublic /* testWhile */ WHILE = 'WHILE';
    constpublic /* testYield */ YIELD = 'YIELD';
    constpublic /* testYieldFrom */YIELD_FROM = 'YIELD_FROM';

    constpublic /* testAnd */ AND = 'LOGICAL_AND';
    constpublic /* testOr */ OR = 'LOGICAL_OR';
    constpublic /* testXor */ XOR = 'LOGICAL_XOR';
}

namespace /* testKeywordAfterNamespaceShouldBeString */ class;
namespace /* testNamespaceNameIsString1 */ my\ /* testNamespaceNameIsString2 */ classuse const;

/* testNamespaceNameIsString3 */ foreach;

/* testAbstractIsKeyword */ abstract /* testClassIsKeyword */
class SomeClass
    /* testExtendsIsKeyword */
    extends SomeParent
    /* testImplementsIsKeyword */
    implements SomeInterface
{

    /* testUseIsKeyword */
    use OtherTrait;
    use SomeTrait;

    /* testConstIsKeyword */
    public const CONSTANT = 'c';

    /* testPrivateIsKeyword */
    private $private;
    /* testProtectedIsKeyword */
    protected $protected;
    /* testPublicIsKeyword */
    public $public;

    /* testVarIsKeyword */
    public $var;
    /* testStaticIsKeyword */
    static public $static;

    /* testReadonlyIsKeyword */
    readonly $readonly;

    /* testFinalIsKeyword */
    public final /* testFunctionIsKeyword */ function someFunction(
        /* testCallableIsKeyword */
        callable $callable,
        /* testSelfIsKeyword */
        self     $self,
        /* testParentIsKeyword */
        parent   $parent
    )
    {

        /* testReturnIsKeyword */
        return $this;
    }

}

/* testInterfaceIsKeyword */ interface SomeInterface {}
/* testTraitIsKeyword */ trait SomeTrait {}
/* testEnumIsKeyword */ enum SomeEnum {}

$object = /* testNewIsKeyword */ new SomeClass();
$object /* testInstanceOfIsKeyword */ instanceof SomeClass;
$copy = /* testCloneIsKeyword */ clone $object;

/* testIfIsKeyword */ if (/* testEmptyIsKeyword */ empty($a)):
/* testElseIfIsKeyword */ elseif (false):
/* testElseIsKeyword */ else:
/* testEndIfIsKeyword */ endif;

/* testForIsKeyword */ for ($i = 0; $i < 100; $i++):
/* testEndForIsKeyword */ endfor;

/* testForeachIsKeyword */ foreach ($array as $value):
/* testEndForeachIsKeyword */ endforeach;

/* testSwitchIsKeyword */ switch (true):
    /* testCaseIsKeyword */case false:
        /* testBreakIsKeyword */
        break;
    /* testDefaultIsKeyword */ default:
        /* testContinueIsKeyword */
        continue;
/* testEndSwitchIsKeyword */ endswitch;

/* testDoIsKeyword */ do {

} while (false);

/* testWhileIsKeyword */ while (false):
/* testEndWhileIsKeyword */ endwhile;

/* testTryIsKeyword */
try {
    /* testThrowIsKeyword */
    throw new Exception();
} /* testCatchIsKeyword */ catch (Exception $e) {

} /* testFinallyIsKeyword */ finally {

}

/* testGlobalIsKeyword */
global $foo;
/* testEchoIsKeyword */
echo $foo;
/* testPrintIsKeyword */
print $foo;
/* testDieIsKeyword */
die($foo);
/* testEvalIsKeyword */
eval('<?php echo 5;');
/* testExitIsKeyword */
exit;
/* testIssetIsKeyword */
$a = isset($a);
/* testUnsetIsKeyword */
unset($a);

/* testIncludeIsKeyword */
include 'file.php';
/* testIncludeOnceIsKeyword */
include_once 'file.php';
/* testRequireIsKeyword */
require 'file.php';
/* testRequireOnceIsKeyword */
require_once 'file.php';

[$a, $b] = /* testListIsKeyword */ list($array);

/* testGotoIsKeyword */
goto label;

$match = /* testMatchIsKeyword */ match ($test) {
    1 => 'a',
    2 => 'b',
    /* testMatchDefaultIsKeyword */ default => 'default',
};

$closure = /* testFnIsKeyword */ fn () => 'string';

function () {
    /* testYieldIsKeyword */ yield $f;
    /* testYieldFromIsKeyword */ yield from someFunction();
};

/* testDeclareIsKeyword */ declare(ticks=1):
/* testEndDeclareIsKeyword */ enddeclare

if (true /* testAndIsKeyword */ and false /* testOrIsKeyword */ or null /* testXorIsKeyword */ xor 0) {

}

$anonymousClass = new /* testAnonymousClassIsKeyword */ class {};
$anonymousClass2 = new class /* testExtendsInAnonymousClassIsKeyword */ extends SomeParent {};
$anonymousClass3 = new class /* testImplementsInAnonymousClassIsKeyword */ implements SomeInterface {};

$instantiated1 = new /* testClassInstantiationParentIsKeyword */ parent();
$instantiated2 = new /* testClassInstantiationSelfIsKeyword */ SELF();
$instantiated3 = new /* testClassInstantiationStaticIsKeyword */ static($param);

class Foo extends /* testNamespaceInNameIsKeyword */ namespace\Exception
{}

function /* testKeywordAfterFunctionShouldBeString */ eval() {}
function /* testKeywordAfterFunctionByRefShouldBeString */ &switch() {}
