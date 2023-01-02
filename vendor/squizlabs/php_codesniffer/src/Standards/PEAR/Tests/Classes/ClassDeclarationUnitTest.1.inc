<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ClassDeclarationUnitTest.1.inc
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

//  Correct declarations.
class CorrectClassDeclaration
{

}

abstract class CorrectClassDeclarationWithExtends extends correctClassDeclaration
{

}

final class CorrectClassDeclarationWithImplements implements correctClassDeclaration
{

}


// Incorrect placement of opening braces
class IncorrectBracePlacement {}
class IncorrectBracePlacementWithExtends extends correctClassDeclaration {}
class IncorrectBracePlacementWithImplements implements correctClassDeclaration {}

// Incorrect code placement for opening brace.
class IncorrectCodeAfterOpeningBrace
{ echo phpinfo();

}//end class

class IncorrectClassDeclarationWithExtends extends correctClassDeclaration

{

}

class IncorrectBracePlacement
 {
 }

abstract class CodeSnifferFail
    extends
        ArrayObject
    implements
        Serializable,
        Iterator,
        Countable,
        OuterIterator,
        RecursiveIterator {
}

abstract class CodeSnifferFail
    extends
        ArrayObject
    implements
        Serializable,
        Iterator,
        Countable,
        OuterIterator,
        RecursiveIterator
{
}

namespace A
{
    class B
    {
    }
}

$util->setLogger(new class {});

var_dump(new class(10) extends SomeClass implements SomeInterface {
    private $num;

    public function __construct($num)
    {
        $this->num = $num;
    }

    use SomeTrait;
});

class IncorrectClassDeclarationWithCommentAtEnd extends correctClassDeclaration /* Comment */ {
}

class CorrectClassDeclarationWithCommentAtEnd extends correctClassDeclaration
/* Comment */
{
}

// Don't move phpcs:ignore comments.
class PHPCSIgnoreAnnotationAfterOpeningBrace
{ // phpcs:ignore Standard.Cat.Sniff -- for reasons.
}

// Moving any of the other trailing phpcs: comments is ok.
class PHPCSAnnotationAfterOpeningBrace
{ // phpcs:disable Standard.Cat.Sniff -- for reasons.
}

if (!class_exists('ClassOpeningBraceShouldBeIndented')) {
    abstract class ClassOpeningBraceShouldBeIndented
{
}
}

if (!class_exists('ClassOpeningBraceTooMuchIndentation')) {
    final class ClassOpeningBraceTooMuchIndentation
        {
        }
}

enum IncorrectBracePlacement {}
