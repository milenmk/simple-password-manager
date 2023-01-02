<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: EnumCaseTest.inc
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

enum Foo
{

    /* testPureEnumCase */
    case SOME_CASE;

}

enum Boo: int
{

    /* testBackingIntegerEnumCase */
    case ONE = 1;

}

enum Hoo: string
{

    /* testBackingStringEnumCase */
    case ONE = 'one';

}

enum ComplexEnum: int implements SomeInterface
{

    use SomeTrait {
        traitMethod as enumMethod;
    }

    public const SOME_CONSTANT = true;

    /* testEnumCaseInComplexEnum */
    case ONE = 1;

    /* testEnumCaseIsCaseInsensitive */
    case TWO = 2;

    public function someMethod(): bool
    {

        switch (true) {
            /* testCaseWithSemicolonIsNotEnumCase */
            case CONSTANT;
        }
    }

    /* testEnumCaseAfterSwitch */
    case THREE = 3;

    public function someOtherMethod(): bool
    {

        switch (true):
            case false:
        endswitch;
    }

    /* testEnumCaseAfterSwitchWithEndSwitch */
    case FOUR = 4;

}

switch (true) {
    /* testCaseWithConstantIsNotEnumCase */
    case CONSTANT:
        /* testCaseWithConstantAndIdenticalIsNotEnumCase */
    case CONSTANT === 1:
        /* testCaseWithAssigmentToConstantIsNotEnumCase */
    case CONSTANT = 1:
        /* testIsNotEnumCaseIsCaseInsensitive */
    case CONSTANT:
}

switch ($x) {
    /* testCaseInSwitchWhenCreatingEnumInSwitch1 */
    case 'a':
    {
        enum Foo
        {

        }

        break;
    }

    /* testCaseInSwitchWhenCreatingEnumInSwitch2 */
    case 'b';
        enum Bar
        {

        }

        break;
}

enum Foo: string
{

    /* testKeywordAsEnumCaseNameShouldBeString1 */
    case INTERFACE = 'interface';
    /* testKeywordAsEnumCaseNameShouldBeString2 */
    case TRAIT = 'trait';
    /* testKeywordAsEnumCaseNameShouldBeString3 */
    case ENUM = 'enum';
    /* testKeywordAsEnumCaseNameShouldBeString4 */
    case FUNCTION = 'function';
    /* testKeywordAsEnumCaseNameShouldBeString5 */
    case FALSE = 'false';
    /* testKeywordAsEnumCaseNameShouldBeString6 */
    case DEFAULT = 'default';
    /* testKeywordAsEnumCaseNameShouldBeString7 */
    case ARRAY = 'array';

}
