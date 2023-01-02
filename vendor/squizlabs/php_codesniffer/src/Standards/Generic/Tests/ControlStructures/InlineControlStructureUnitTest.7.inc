<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: InlineControlStructureUnitTest.7.inc
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

// Issue #2565.
// Important note: this file intentionally does not have a ".fixed" version as
// when `short_open_tag=Off`, no fixes will be made, while when `short_open_tag=On`
// no fixes are necessary.
?>

<?php if (true) : ?>
<? endif ?>
<?php if (true) { ?>
<? } ?>

<? if (false) : ?>
<? endif ?>
<?php if (false) { ?>
<?php } ?>
