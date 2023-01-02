<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: IncludeSystemUnitTest.inc
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

Channels::includeSystem('MySystem');
Channels::includeAsset('Page');
require_once 'libs/FileSystem2.inc';

function one() {
    Channels::includeSystem('MySystem2');
    $siteid = MySystem2::getCurrentSiteId();
    Page::create();
    PageAssetType::create();
}

function two() {
    $siteid = MySystem2::getCurrentSiteId();
    $parserFiles = FileSystem2::listDirectory();
}

function three() {
    include 'libs/FileSystem.inc';
    $siteid = MySystem::getCurrentSiteId();
    $parserFiles = FileSystem::listDirectory();
}

$siteid = MySystem2::getCurrentSiteId();
$parserFiles = FileSystem2::listDirectory();
$siteid = MySystem::getCurrentSiteId();
$parserFiles = FileSystem::listDirectory();
Page::create();
PageAssetType::create();

class AssetListingAssetType extends AssetAssetType
{

    public function one()
    {

        Channels::includeSystem('MySystem2');
        $siteid = MySystem2::getCurrentSiteId();
        Page::create();
        PageAssetType::create();
    }

    public function two()
    {

        $siteid = MySystem2::getCurrentSiteId();
        $parserFiles = FileSystem2::listDirectory();

        return parent::two();
    }

    public function three()
    {

        include 'libs/FileSystem.inc';
        $siteid = MySystem::getCurrentSiteId();
        $parserFiles = FileSystem::listDirectory();
        echo self::two();
        echo static::two();
    }

}

echo Init::ROOT_DIR;

Channels::includeSystem('AssetType');
AssetType::includeAsset('User');
AssetType::includeAsset('FolderAsset');
UserAssetType::create();
FolderAssetType::create();
$query->fetch(PDO::FETCH_NUM)
BaseSystem::getDataDir();
Util::getArrayIndex(array(), '');


Channels::includeSystem('Widget');
Widget::includeWidget('AbstractContainer');
class MyWidget extends AbstractContainerWidgetType {}
class MyOtherWidget extends BookWidgetType {}

$zip = new ZipArchive();
$res = $zip->open($path, ZipArchive::CREATE);

class AssetListingUnitTest extends AbstractMySourceUnitTest
{

    public function setUp()
    {

        parent::setUp();
        Channels::includeSystem('MySystem2');
        include_once 'Libs/FileSystem.inc';
    }

    public function two()
    {

        $siteid = MySystem2::getCurrentSiteId();
        $parserFiles = FileSystem::listDirectory();
    }

    public function three()
    {

        $siteid = MySystem3::getCurrentSiteId();
        $parserFiles = FileSystem::listDirectory();
    }

}

if (Channels::systemExists('Log') === TRUE) {
   Channels::includeSystem('Log');
} else {
   return;
}

Log::addProjectLog('metadata.field.update', $msg);

function two() {
    Widget::includeWidget('CacheAdminScreen');
    $barChart = CacheAdminScreenWidgetType::constructBarchart($data);
}

$adjustDialog->setOrientation(AbstractWidgetWidgetType::CENTER);

$className = 'SquizPerspective'.ucfirst($property['type']).'PropertyType';
Channels::includeSystem($className);
$className::setValue($assetid, $propertyid, $perspectives, $value, (array) $property['settings']);
?>
