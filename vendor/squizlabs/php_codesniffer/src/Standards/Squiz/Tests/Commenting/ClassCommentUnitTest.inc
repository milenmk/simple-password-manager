<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ClassCommentUnitTest.inc
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

/** Class doc comment */

class Comment
{

}//end class


//
// Sample class comment
//
//
//
class Invalid_Comment_Style1
{

}//end class

/**
 *
 *
 * Sample class comment.
 *
 *
 * Long description with extra blank line before and after
 *
 *
 * @version   Release: 1.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

class Extra_Description_Newlines
{

}//end class


/**
 * Sample class comment...
 */
class Missing_Newlines_Before_Tags
{

}//end class

/**
 * Simple class comment
 *
 * @deprecated asd
 */
class Checking_Tags
{
    class Sub_Class {

    }//end class


}//end class

/**
 * Simple class comment
 * that spans multiple line
 * and not end with a full stop
 *
 * @hello      Hello tag
 * @package    phpcs
 */
class Unknown_Hello_Tag
{

}//end class

/**
 *
 *
 *
 */
class Empty_Class_Doc
{

}//end class

/**
 */
class Missing_Short_Desc
{

}//end class

/**
 * sample class comment.
 *
 * - long description with extra blank line before and after
 */
class Incorrect_Case
{

}//end class

/**
 * 0sample class comment.
 *
 * long description with extra blank line before and after
 */
class Incorrect_Case2
{

}//end class

/** Sample class comment.
 */
class Start_Tag_Incorrect
{

}//end class

/**
 * 这是一条测试评论.
 *
 */
class Space_At_end
{

}//end class

/**
 * Sample class comment
 */
#[Attribute]
class AllGood
{
}
