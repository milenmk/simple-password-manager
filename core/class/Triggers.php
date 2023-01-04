<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Triggers.php
 *  Last Modified: 4.01.23 г., 19:20 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       2.3.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        class/Triggers.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for Triggers class (Create/Read/Update/Delete)
 */

declare(strict_types=1);

namespace PasswordManagerCore;

use Exception;
use PasswordManager\PassManDb;

/**
 * Class for Triggers
 */
class Triggers
{
    /**
     * @var PassManDb Database handler
     */
    private PassManDb $db;

    /**
     * @throws Exception
     */
    public function __construct(PassManDb $db)
    {

        $this->db = $db;
    }
    public function runTrigger($action, $id, $object)
    {

        switch ($action) {
            case 'RECORD_UPDATE':
                //
                break;
            case 'RECORD_DELETE':
                ////
                break;
            case 'RECORD_INSERT':
                //////
                break;
            default:
                pm_syslog("Trigger '" . get_class($this) . "' 
                    for action '$action' launched by " . $object . '. for record id=' . $id, LOG_INFO);
                break;
        }

        return 0;
    }
}
