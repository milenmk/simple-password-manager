<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Triggers.php
 *  Last Modified: 17.01.23 г., 12:55 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       3.0.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
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
    public function runTrigger($action, $object)
    {

        switch ($action) {
            case 'RECORD_INSERT':
                $obj = new Domains($this->db);

                if (!$this->db->db->inTransaction()) {
                    $this->db->db->beginTransaction();
                }

                if ($object->type == 1) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET data_base = data_base + 1 WHERE rowid = ' . $object->fk_domain);
                    $this->db->db->commit();
                } elseif ($object->type == 2) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET website = website + 1 WHERE rowid = ' . $object->fk_domain);
                    $this->db->db->commit();
                } elseif ($object->type == 3) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET ftp = ftp + 1 WHERE rowid = ' . $object->fk_domain);
                    $this->db->db->commit();
                }
                break;
            case 'RECORD_UPDATE':
                $obj = new Domains($this->db);

                if (!$this->db->db->inTransaction()) {
                    $this->db->db->beginTransaction();
                }

                if ($object->old_fk_domain) {
                    if ($object->old_type == 1) {
                        $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET data_base = data_base - 1 WHERE rowid = ' . $object->old_fk_domain);
                        $this->db->db->commit();
                    } elseif ($object->old_type == 2) {
                        $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET website = website - 1 WHERE rowid = ' . $object->old_fk_domain);
                        $this->db->db->commit();
                    } elseif ($object->old_type == 3) {
                        $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET ftp = ftp - 1 WHERE rowid = ' . $object->old_fk_domain);
                        $this->db->db->commit();
                    }
                } else {
                    if ($object->old_type == 1) {
                        $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET data_base = data_base - 1 WHERE rowid = ' . $object->fk_domain);
                        $this->db->db->commit();
                    } elseif ($object->old_type == 2) {
                        $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET website = website - 1 WHERE rowid = ' . $object->fk_domain);
                        $this->db->db->commit();
                    } elseif ($object->old_type == 3) {
                        $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET ftp = ftp - 1 WHERE rowid = ' . $object->fk_domain);
                        $this->db->db->commit();
                    }
                }
                if (!$this->db->db->inTransaction()) {
                    $this->db->db->beginTransaction();
                }
                if ($object->type == 1) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET data_base = data_base + 1 WHERE rowid = ' . $object->fk_domain);
                    $this->db->db->commit();
                } elseif ($object->type == 2) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET website = website + 1 WHERE rowid = ' . $object->fk_domain);
                    $this->db->db->commit();
                } elseif ($object->type == 3) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET ftp = ftp + 1 WHERE rowid = ' . $object->fk_domain);
                    $this->db->db->commit();
                }
                break;
            case 'RECORD_DELETE':
                $objsrc = new Records($this->db);
                $res = $objsrc->fetch($object->id);
                $obj = new Domains($this->db);

                if (!$this->db->db->inTransaction()) {
                    $this->db->db->beginTransaction();
                }

                if ($res->type == 1) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET data_base = data_base - 1 WHERE rowid = ' . $res->fk_domain);
                    $this->db->db->commit();
                } elseif ($res->type == 2) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET website = website - 1 WHERE rowid = ' . $res->fk_domain);
                    $this->db->db->commit();
                } elseif ($res->type == 3) {
                    $this->db->db->exec('UPDATE ' . PM_MAIN_DB_PREFIX . $obj->table_element . ' SET ftp = ftp - 1 WHERE rowid = ' . $res->fk_domain);
                    $this->db->db->commit();
                }
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
