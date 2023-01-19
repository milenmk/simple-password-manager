<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Admin.php
 *  Last Modified: 19.01.23 г., 22:28 ч.
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
 * \file        class/Admin.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for Admin class (Create/Read/Update/Delete)
 */

declare(strict_types=1);

namespace PasswordManager;

use Exception;
use PDO;
use PDOException;

/**
 * Class for Admin
 */
class Admin
{
    /**
     * @var int Option id
     */
    public int $id;

    /**
     * @var string Option name
     */
    public string $name;

    /**
     * @var string Option value
     */
    public string $value;

    /**
     * @var string Option description
     */
    public string $description;

    public string $error;

    /**
     * @var PassManDb Database handler
     */
    private PassManDb $db;

    /**
     * @param PassManDb $db Database handler
     */
    public function __construct(PassManDb $db)
    {

        $this->db = $db;
        $this->error = $this->db->error;
    }

    /**
     * Fetch number of records in table
     *
     * @param string $table Table name
     *
     * @return int|null
     * @throws Exception
     *
     */
    public function fetchNumRecords(string $table)
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $query = $this->db->fetchAll($table, '');

        if ($query > 0) {
            return count($query);
        } else {
            return 0;
        }
    }

    /**
     * Fetch last X records from table
     *
     * @param string $table The table to fetch from
     * @param string $where     The WHERE clause of the query
     * @param array  $params    An array of parameters to bind to the query
     * @param string $other     Other options like GROUP BY, SORT BY, LIMIT, etc.
     *
     * @return array|false|int
     * @throws Exception
     *
     */
    public function lastXrecords(string $table, string $where = '', array $params = [], string $other = '')
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $query = $this->db->fetchAll($table, $where, $params, $other);

        if ($query > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    /**
     * Select top X users by records in a given table
     *
     * @param string $table Table name
     * @param int    $limit Records limit
     *
     * @return array|int
     * @throws Exception
     *
     */
    public function topXby(string $table, int $limit = 0)
    {
        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $sql = 'SELECT count(t.rowid) as numrec, u.first_name, u.last_name, u.username 
                FROM ' . PM_MAIN_DB_PREFIX . $table . ' as t 
                INNER JOIN ' . PM_MAIN_DB_PREFIX . 'users as u ON u.rowid = t.fk_user 
                GROUP BY t.fk_user ORDER BY numrec DESC LIMIT ' . $limit;
        $query = $this->db->db->prepare($sql);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        } else {
            return -1;
        }
    }

    /**
     * @throws Exception
     */
    public function fetchOptions()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->fetchAll('options', '');
        $options = [];
        if ($result) {
            foreach ($result as $row) {
                $option = new self($this->db);
                $option->id = (int)$row['rowid'];
                $option->name = (string)$row['name'];
                $option->value = (string)$row['value'];
                if ($row['description']) {
                    $option->description = $row['description'];
                }
                $options[] = $option;
            }

            return $options;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * Update options data
     *
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */
    public function updateOption()
    {
        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $data = [
            'name' => $this->name,
            'value'  => $this->value,
        ];
        if (!empty($this->description)) {
            $data['description'] = $this->description;
        }

        $result = $this->db->update('options', $data, "rowid = $this->id");

        if ($result > 0) {
            return 1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }
}
