<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: IncludingFileUnitTest.inc
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

// These are statements and should not have brackets.
require_once('blank.inc');
require('blank.inc');

$test = true;

// Conditionally including a class file: use include_once
if ($test) {
    require_once 'blank.inc';
    require 'blank.inc';
}

// Unconditionally including a class file: use require_once
include_once 'blank.inc';
include 'blank.inc';


// These are ok
if ($test) {
    include_once 'blank.inc';
    include 'blank.inc';
}

require_once 'blank.inc';
require 'blank.inc';

?>
<pre>
Some content goes here.
<?php
include_once 'blank.inc';
include 'blank.inc';
require_once 'blank.inc';
require 'blank.inc';
?>
</pre>
<?php

if (include_once 'blank.inc') {
    $var = include_once 'blank.inc';
    if ($var === true) {
    }
}

if (require_once 'blank.inc') {
    $var = require_once 'blank.inc';
    if ($var === true) {
    }
}

function get_some_value()
{
    include_once 'blank.inc';
    include 'blank.inc';

    // These are ok
    if ($test) {
        include_once 'blank.inc';
        include 'blank.inc';
    }

    require_once 'blank.inc';
    require 'blank.inc';

    ?>
    <pre>
    Some content goes here.
    <?php
    include_once 'blank.inc';
    include 'blank.inc';
    require_once 'blank.inc';
    require 'blank.inc';
    ?>
    </pre>
    <?php

    if (include_once 'blank.inc') {
        $var = include_once 'blank.inc';
        if ($var === true) {
        }
    }
    
    if (require_once 'blank.inc') {
        $var = require_once 'blank.inc';
        if ($var === true) {
        }
    }
}


$var = include_once 'blank.inc';
if ($var == false) {

}

require_once ('blank.inc');
include_once ('blank.inc');
