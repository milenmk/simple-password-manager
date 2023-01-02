<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: ScopeClosingBraceUnitTest.inc
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

class Test
{

    public function __construct() {}

    public function test1() {}

    public function test2() {}

    private function _test3() {}

}


class Test2
{
 }


function test2()
{
    if ($str{0}) {
        $chr = $str{0}; }


    if (!class_exists($class_name)) {
        echo $error;
    }
    $this->{$property} =& new $class_name($this->db_index);
    $this->modules[$module] =& $this->{$property};
}

foreach ($elements as $element) {
    if ($something) {
        // Do IF.
    } else if ($somethingElse) {
        // Do ELSE.
    }
}

switch ($foo) {
case 1:
    switch ($bar) {
    default:
        if ($something) {
            echo $string{1};
        } else if ($else) {
            switch ($else) {
            case 1:
                // Do something.
                break;
            default:
                // Do something.
            break;
            }
        }
    }
break;
case 2:
    // Do something;
    break;
}

switch ($httpResponseCode) {
    case 100:
    case 101:
    case 102:
    default:
        return 'Unknown';
}

switch ($httpResponseCode) {
    case 100:
    case 101:
    case 102:
        return 'Processing.';
    default:
    return 'Unknown';
}

switch($i) {
case 1: {}
}

switch ($httpResponseCode) {
    case 100:
    case 101:
    case 102:
        exit;
    default:
    exit;
}

if ($foo):
    if ($bar):
        $foo = 1;
    elseif ($baz):
        $foo = 2;
    endif;
endif;

if ($foo):
elseif ($baz): $foo = 2;
endif;

?>
<ul>
    <?php foreach ($array as $value) : ?>
        <li><?php echo $value ?></li>
    <?php endforeach ?>
</ul>
<ul>
    <?php foreach ($array as $value) : ?>
        <li><?php echo $value ?></li>
<?php endforeach ?>
</ul>
<ul>
    <?php foreach ($array as $value) : ?>
        <li><?php echo $value ?></li>
            <?php endforeach ?>
</ul>
<?php
switch ( $a ) {
    case 'foo':
        do {
            $a = 'b';
        } while ( $a );
    return 5;

    case 'bar':
        foreach ( $a as $b ) {
            $e = 'b';
        }
    return 5;
}

?>
<?php $_cartQty = $this->getSummaryCount(); ?>
<div id="minicart" <?php if ($_cartQty == 0): ?>class="empty"<?php endif; ?>>

<?php
$match = match ($test) { 1 => 'a', 2 => 'b' };

$match = match ($test) {
    1 => 'a',
    2 => 'b'
    };

enum Enum
{
}

enum Suits {}

enum Cards
{
    }
