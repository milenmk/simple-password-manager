<?php if (isset($param)) { ?>
   <h3>some text</h3>
<?php }

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: MultiLineConditionUnitTest.inc
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

if (($condition1
    || $condition2)
    && $condition3
    && $condition4
    && $condition5
) {
}

if (($condition1 || $condition2) && $condition3 && $condition4 && $condition5) {
}

if (($condition1 || $condition2)
    && $condition3
) {
}

if (
    ($condition1 || $condition2)
    && $condition3
) {
}

if (($condition1
    || $condition2)
) {
}

if (($condition1
    || $condition2)
    && $condition3 &&
    $condition4
) {
}

if (($condition1
   || $condition2)
      && $condition3
   && $condition4
   && $condition5
) {
}

if (($condition1
    || $condition2)
)  {
}

if (($condition1
    || $condition2)
 ) {
}

if (
    (
    $condition1
    || $condition2
    )
    && $condition3
) {
}


if (   $condition1
    || $condition2
    || $condition3
) {
}

if ($condition1
    || $condition2
    || $condition3
) {
} else if ($condition1
    || $condition2
    || $condition3
) {
}

if ($condition1
    || $condition2
    || $condition3
) {
} elseif (
    $condition1
   || $condition2 &&
    $condition3
) {
}

if ($condition1
    || $condition2
|| $condition3) {
}

if ($condition1
    || $condition2 || $condition3
){
}

if ($condition1)
    echo 'bar';

if ($condition1
    || $condition2
|| $condition3)
    echo 'bar';


if ($condition1
    || $condition2 || $condition3
)
    echo 'bar';

if (!empty($post)
    && (!empty($context['header'])
    xor stripos($context['header'], 'Content-Type'))
) { 
// ...
}

if ($foo)
{
    echo 'bar';
}

// Should be no errors even though lines are
// not exactly aligned together. Multi-line function
// call takes precedence.
if (array_key_exists($key, $value)
    && array_key_exists(
        $key, $value2
    )
) {
}

if (true) :
    $foo = true;
endif;

if ($IPP->errorCode() == 401 || // comment
    $IPP->errorCode() == 3200)  /* long comment
                                   here
                                 */
{
    return false;
}

if ($IPP->errorCode() == 401 || // comment
    $IPP->errorCode() == 3200)  // long comment here
{
    return false;
}

if ($IPP->errorCode() == 401
    // Comment explaining the next condition here.
    || $IPP->errorCode() == 3200
) {
    return false;
}

function bar() {
    if ($a
        && $b
) {
        return false;
    }
}

if ($a
    && foo(
        'a',
        'b'
    )) {
    return false;
}

?>
<?php foreach ($blah as $boo) : ?>
    <?php if ($foo): ?>
        <?php
            if ($bar) {
            } else {
            }
        ?>
    <?php endif; ?>
<?php endforeach; ?>
<?php

if ($IPP->errorCode() == 401 || // phpcs:ignore Standard.Category.Sniff -- for reasons.
    $IPP->errorCode() == 3200)  /*
                                   phpcs:ignore Standard.Category.Sniff -- for reasons.
                                 */
{
    return false;
}

if ($IPP->errorCode() == 401 || // phpcs:disable Standard.Category.Sniff -- for reasons.
    $IPP->errorCode() == 3200)  // phpcs:enable
{
    return false;
}

if ($IPP->errorCode() == 401
    // phpcs:ignore Standard.Category.Sniff -- for reasons.
    || $IPP->errorCode() == 3200
) {
    return false;
}

    if ($IPP->errorCode() == 401 ||
    /*
     * phpcs:disable Standard.Category.Sniff -- for reasons.
     */
    $IPP->errorCode() == 3200
    ) {
        return false;
    }

if ($IPP->errorCode() == 401
    || $IPP->errorCode() == 3200
    // phpcs:ignore Standard.Category.Sniff -- for reasons.
) {
    return false;
}

if ($IPP->errorCode() == 401
    || $IPP->errorCode()
        === 'someverylongexpectedoutput'
) {
    return false;
}

if ($IPP->errorCode() == 401
    || $IPP->errorCode()
        // A comment.
        === 'someverylongexpectedoutput'
) {
    return false;
}

if ($IPP->errorCode() == 401
    || $IPP->errorCode()
        // phpcs:ignore Standard.Category.Sniff -- for reasons.
        === 'someverylongexpectedoutput'
) {
    return false;
}
