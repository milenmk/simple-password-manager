<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DisallowSelfActionsUnitTest.inc
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

class SomethingActions
{

    private static function _x()
    {
    }


    public static function y()
    {
        self::z();
        static::z();
        SomethingActions::z();
        static::_x();
        self::a();
        static::a();
    }


    public static function z()
    {
    }

    protected static function a()
    {
        self::a(); // recursion, yay!
        self::z();
        static::y();
        self::b();
        echo self::$_myVar;
        echo static::$yourVar;
    }
}

abstract class AbstractEditingScreenModeWidgetActions extends AbstractEditingModeWidgetActions {

    public static function getScreens($systemName)
    {

    }//end getScreens()

    public static function setHelpScreenTitle()
    {
        // This is allowed because we are in an abstract class.
        $screens = self::getScreens('');

    }//end setHelpScreenTitle()

}//end class
?>
