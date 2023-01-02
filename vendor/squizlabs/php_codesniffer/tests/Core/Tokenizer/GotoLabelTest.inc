<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: GotoLabelTest.inc
 *  Last Modified: 3.01.23 г., 0:07 ч.
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

/* testGotoStatement */
goto marker;
echo 'Foo';

/* testGotoDeclaration */
marker:
echo 'Bar';

/* testGotoStatementInLoop */
for ($i = 0, $j = 50; $i < 100; $i++) {
    while ($j--) {
        if ($j == 17) goto end;
    }
}
echo "i = $i";
?>
    <div><?php $cond ? TEST_A : TEST_B ?></div>

<?php
/* testGotoDeclarationOutsideLoop */

end:
echo 'j hit 17';

switch ($x) {
    /* testNotGotoDeclarationGlobalConstant */
    case CONSTANT:
        // Do something.
        break;

    /* testNotGotoDeclarationNamespacedConstant */
    case MyNS\CONSTANT:
        // Do something.
        break;

    /* testNotGotoDeclarationClassConstant */
    case MyClass::CONSTANT:
        // Do something.
        break;

    /* testNotGotoDeclarationClassProperty */
    case $obj->property:
        // Do something.
        break;
}

switch (true) {
    /* testNotGotoDeclarationGlobalConstantInTernary */
    case $x === ($cond) ? CONST_A : CONST_B:
        // Do something.
        break;
}

/* testNotGotoDeclarationEnumWithType */

enum Suit: string implements Colorful, CardGame
{

}
