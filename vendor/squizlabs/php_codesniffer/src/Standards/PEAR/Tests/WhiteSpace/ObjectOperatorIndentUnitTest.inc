<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ObjectOperatorIndentUnitTest.inc
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

$someObject->someFunction('some', 'parameter')
->someOtherFunc(23, 42)->
    someOtherFunc2($one, $two)

 ->someOtherFunc3(23, 42)
    ->andAThirdFunction();

    $someObject->someFunction('some', 'parameter')
        ->someOtherFunc(23, 42);

$someObject->someFunction('some', 'parameter')->someOtherFunc(23, 42);

$someObject->someFunction('some', 'parameter')
        ->someOtherFunc(23, 42);

func(
    $bar->foo()
)
    ->bar();

func(
    $bar->foo()
)
    ->bar(
        $bar->foo()
        ->bar()
            ->func()
    );

$object
    ->setBar($foo)
    ->setFoo($bar);

if ($bar) {
    $object
    ->setBar($foo)
    ->setFoo($bar);
}

$response -> CompletedTrackDetails -> TrackDetails -> Events;
$response
    -> CompletedTrackDetails
    -> TrackDetails
    -> Events;

$response
     -> CompletedTrackDetails
-> TrackDetails
 -> Events;

$var = get_object(
    $foo->something()
        ->query()
)->two()
    ->three();

$foo->one(
    $foo
            ->two()
);

get_object()->one()
    ->two()
        ->three();

someclass::one()
    ->two()
        ->three();

(new someclass())->one()
    ->two()
        ->three();

// phpcs:set PEAR.WhiteSpace.ObjectOperatorIndent multilevel true

$someObject
    ->startSomething()
                    ->someOtherFunc(23, 42)
->endSomething()
->doSomething(23, 42)
->endEverything();

$rootNode
    ->one()
        ->two()
            ->three()
        ->four()
    ->five();

$rootNode
    ->one()
        ->two()
            ->three()
    ->four()
    ->five();

$rootNode
    ->one()
    ->two()
        ->three()
    ->four()
->five();

$rootNode
    ->one()
        ->two()
            ->three()
        ->four()
        ->five();

// phpcs:set PEAR.WhiteSpace.ObjectOperatorIndent multilevel false

$object
    ?->setBar($foo)
    ?->setFoo($bar);

$someObject?->someFunction('some', 'parameter')
->someOtherFunc(23, 42)?->
    someOtherFunc2($one, $two)

->someOtherFunc3(23, 42)
    ?->andAThirdFunction();

// phpcs:set PEAR.WhiteSpace.ObjectOperatorIndent multilevel true
$object
    ?->setBar($foo)
        ?->setFoo($bar);

$someObject?->someFunction('some', 'parameter')
->someOtherFunc(23, 42)
        ?->someOtherFunc2($one, $two)

->someOtherFunc3(23, 42)
    ?->andAThirdFunction();
// phpcs:set PEAR.WhiteSpace.ObjectOperatorIndent multilevel false

$someObject
    ->startSomething(paramName: $value)
                    ->someOtherFunc(nameA: 23, nameB: 42)
->endSomething($value, name: $value)
->endEverything();
