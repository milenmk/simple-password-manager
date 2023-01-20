<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Triggers.php
 *  Last Modified: 19.01.23 г., 22:46 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       3.0.0
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

declare(strict_types = 1);

namespace PasswordManagerCore;

use Exception;
use PasswordManager\Domains;
use PasswordManager\PassManDb;
use PasswordManager\Records;

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

    /**
     * @param string $action Action
     * @param Object $object Source object
     *
     * @return int
     * @throws Exception
     */
    public function runTrigger(string $action, object $object)
    {

        $obj = new Domains($this->db);

        if (!empty($object->type)) {
            if ($object->type == 1) {
                $object->type = 'data_base';
            } elseif ($object->type == 2) {
                $object->type = 'website';
            } elseif ($object->type == 3) {
                $object->type = 'ftp';
            }
        }

        if (!$this->db->db->inTransaction()) {
            $this->db->db->beginTransaction();
        }

        switch ($action) {
            case 'RECORD_INSERT':
                if (!$this->db->db->inTransaction()) {
                    $this->db->db->beginTransaction();
                }

                $this->db->db->exec(
                    'UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' 
                    SET ' . $object->type . ' = ' . $object->type . ' + 1 WHERE rowid = ' . $object->fk_domain
                );
                $this->db->db->commit();
                break;
            case 'RECORD_UPDATE':
                if ($object->old_type == 1) {
                    $object->old_type = 'data_base';
                } elseif ($object->old_type == 2) {
                    $object->old_type = 'website';
                } elseif ($object->old_type == 3) {
                    $object->old_type = 'ftp';
                }

                if ($object->old_fk_domain) {
                    $this->db->db->exec(
                        'UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . '
                        SET ' . $object->old_type . ' = ' . $object->old_type . ' - 1 
                        WHERE rowid = ' . $object->old_fk_domain
                    );
                } else {
                    $this->db->db->exec(
                        'UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . '
                        SET ' . $object->old_type . ' = ' . $object->old_type . ' - 1 
                        WHERE rowid = ' . $object->fk_domain
                    );
                }

                $this->db->db->exec(
                    'UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . '
                    SET ' . $object->type . ' = ' . $object->type . ' + 1 WHERE rowid = ' . $object->fk_domain
                );
                $this->db->db->commit();

                break;
            case 'RECORD_DELETE':
                $this->db->db->exec(
                    'UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' 
                    SET ' . $object->type . ' = ' . $object->type . ' - 1 WHERE rowid = ' . $object->fk_domain
                );
                $this->db->db->commit();
                break;
            default:
                pm_syslog(
                    "Trigger '" . get_class($this) . "' 
                    for action '$action' launched by " . $object . '. for record id=' . $object->id,
                    LOG_INFO
                );
                break;
        }

        return 0;
    }
}
