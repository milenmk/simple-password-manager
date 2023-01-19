<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Records.php
 *  Last Modified: 17.01.23 г., 12:43 ч.
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
 * \file        class/Records.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for Records class (Create/Read/Update/Delete)
 */

declare(strict_types=1);

namespace PasswordManager;

use Exception;
use PasswordManagerCore\Triggers;
use PDOException;

/**
 * Class for records
 */
class Records
{
    /**
     * @var int Object id
     */
    public int $id;

    /**
     * @var int Parent ID
     */
    public int $fk_domain;
    /**
     * @var int Parent ID
     */
    public int $old_fk_domain;
    /**
     * @var int
     */
    public int $type;
    /**
     * @var int
     */
    public int $old_type;
    /**
     * @var string
     */
    public string $url;
    /**
     * @var string
     */
    public string $username;
    /**
     * @var string
     */
    public string $pass_crypted;
    /**
     * @var int
     */
    public int $fk_user;
    /**
     * @var string Name of table without prefix where object is stored.
     */
    public string $table_element = 'records';

    /**
     * @var PassManDb Database handler
     */
    private PassManDb $db;
    /**
     * @var Triggers Class to manage triggers
     */
    private Triggers $trigger;

    /**
     * @param PassManDb $db Database handler
     *
     * @throws Exception
     */
    public function __construct(PassManDb $db)
    {

        $this->db = $db;
        $this->db->error = '';
        $this->trigger = new Triggers($this->db);
    }

    /**
     * Insert record in database
     *
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */
    public function create()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $this->pass_crypted = password_hash($this->pass_crypted, PASSWORD_DEFAULT);
        $data = [
            'fk_domain'    => $this->fk_domain,
            'type'         => $this->type,
            'url'          => $this->url,
            'username'     => $this->username,
            'pass_crypted' => $this->pass_crypted,
            'fk_user'      => $this->fk_user,
        ];
        $result = $this->db->create($this->table_element, $data);

        if ($result > 0) {
            $res = $this->trigger->runTrigger('RECORD_INSERT', $this);
            if ($res > 0) {
                return 1;
            } else {
                $_SESSION['PM_ERROR'] = $this->db->error;

                return -1;
            }
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -2;
        }
    }

    /**
     * Update record in database
     *
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */
    public function update()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $this->pass_crypted = password_hash($this->pass_crypted, PASSWORD_DEFAULT);
        $data = [
            'fk_domain'    => $this->fk_domain,
            'type'         => $this->type,
            'url'          => $this->url,
            'username'     => $this->username,
            'pass_crypted' => $this->pass_crypted,
        ];
        if (!empty($this->password)) {
            $data['password'] = password_hash($this->password, PASSWORD_DEFAULT);
        }

        $result = $this->db->update($this->table_element, $data, "rowid = $this->id");

        if ($result > 0) {
            $res = $this->trigger->runTrigger('RECORD_UPDATE', $this);
            if ($res > 0) {
                return 1;
            } else {
                $_SESSION['PM_ERROR'] = $this->db->error;

                return -1;
            }
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -2;
        }
    }

    /**
     * Delete record from database
     *
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     */
    public function delete()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $res = $this->trigger->runTrigger('RECORD_DELETE', $this);

        if ($res >= 0) {
            $result = $this->db->delete($this->table_element, 'rowid = :id', [':id' => $this->id]);
            if ($result > 0) {
                return 1;
            } else {
                $_SESSION['PM_ERROR'] = $this->db->error;

                return -1;
            }
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -2;
        }
    }

    /**
     * Fetch all records from database
     *
     * @param string $where  The WHERE clause of the query
     * @param array  $params An array of parameters to bind to the query
     *
     * @return array|int Array of objects or <0 on error
     * @throws Exception
     */
    public function fetchAll(string $where, array $params = [])
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->fetchAll($this->table_element, $where, $params);
        $records = [];
        if ($result) {
            foreach ($result as $row) {
                $record = new self($this->db);
                $record->id = (int)$row['rowid'];
                $record->fk_domain = (int)$row['fk_domain'];
                $record->type = (int)$row['type'];
                $record->url = $row['url'];
                $record->username = $row['username'];
                $record->pass_crypted = $row['pass_crypted'];
                $record->fk_user = (int)$row['fk_user'];
                $records[] = $record;
            }

            return $records;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * Fetch a single record from database
     *
     * @param int $id The ID of the record to fetch
     *
     * @return Records|int Return Object or <0 on error
     * @throws Exception
     */
    public function fetch(int $id)
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->fetch($this->table_element, 'rowid = :id', [':id' => $id]);
        if ($result) {
            $this->id = (int)$result['rowid'];
            $this->fk_domain = (int)$result['fk_domain'];
            $this->type = (int)$result['type'];
            $this->url = $result['url'];
            $this->username = $result['username'];
            $this->pass_crypted = $result['pass_crypted'];
            $this->fk_user = (int)$result['fk_user'];

            return $this;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }
}
