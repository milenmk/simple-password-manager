<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: UnusedSystemUnitTest.inc
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

Channels::includeSystem('OurSystem');
Channels::includeSystem('Page');
Channels::includeAsset('Page2');
Channels::includeAsset('Folder');

function one() {
    Channels::includeSystem('MySystem');
    $siteid = MySystem2::getCurrentSiteId();
    Page::create();
    PageAssetType::create();
}

function two() {
    Page2AssetType::create();
    Folder::getFolder();
}

Channels::includeAsset('Asset');

class AssetListingAssetType extends AssetAssetType
{

    public function one()
    {

        Channels::includeSystem('MySystem2');
        Channels::includeSystem('Page2');
        $siteid = MySystem2::getCurrentSiteId();
    }

    public function two()
    {

        $siteid = Page2::getCurrentSiteId();
    }

}

Channels::includeSystem('Log');
Channels::includeSystem('Log4');
class MyLog implements Dog, Log extends LogMe {}

Channels::includeSystem('Log1');
class MyLog implements Dog, Log1 extends LogMe {}

class MyLog implements Log2 {}

Channels::includeSystem('Log3');
class MyLog implements Log3 {}

if (self::systemExists($systemName) === FALSE) {
    return $actions;
} else {
    // Shouldn't throw an error because we don't know the system name.
    self::includeSystem($systemName);
    self::includeSystem($systemNames['log']);
}

Channels::includeSystem('Widget');
Widget::includeWidget('AbstractContainer');
class MyOtherWidget extends BookWidgetType {}

function myFunction()
{
    if (Channels::systemExists('Log5') === TRUE) {
       Channels::includeSystem('Log5');
    } else {
       return;
    }

    Log5::addProjectLog('metadata.field.update', $msg);
}
?>