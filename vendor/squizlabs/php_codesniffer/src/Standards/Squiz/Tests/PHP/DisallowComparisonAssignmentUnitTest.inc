<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: DisallowComparisonAssignmentUnitTest.inc
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

$var = TRUE;
$var = ($foo === $bar);
$var = ($foo * $bar);
$var = !$foo;
$var = ($foo || $bar);
$var = ($foo === TRUE);
$var = ($foo === TRUE
        || $bar === FALSE);
$var = (!$foo);

$var = is_array($foo);
$var = myFunction($one, $two);
$var = myFunction(
        'one',
        'two'
       );

for ($i = ($stackPtr + 1); $i < $endStatement; $i++) {
}

// These conditions are allowed by this sniff.
$var = myFunction(!$var);

$depthAdv = array(
             $this,
             !$directLinks,
             FALSE,
            );

$var = myFunction(
    $var,
    array(
     $this,
     !$directLinks,
     FALSE,
    );
)

for ($node = $fieldsTag->nextSibling; $node; $node = $node->nextSibling) {
    if ($node->nodeType !== XML_ELEMENT_NODE) {
        continue;
    }

    for ($node = $fields->nextSibling; $node; $node = $node->nextSibling) {
        if ($node->nodeType !== XML_ELEMENT_NODE) {
            continue;
        }
    }
}

$a = $b ? $c : $d;
$a = $b === true ? $c : $d;

$this->_args = $this->_getArgs(($_SERVER['argv'] ?? []));
$args = ($_SERVER['argv'] ?? []);

$a = [
    'a' => ($foo) ? $foo : $bar,
];

$a = [
    'a' => ($foo) ? fn() => return 1 : fn() => return 2,
]

$var = $foo->something(!$var);
$var = $foo?->something(!$var);

$callback = function ($value) {
    if ($value > 10) {
        return false;
    }
};
