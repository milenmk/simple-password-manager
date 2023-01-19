<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Admin.php
 *  Last Modified: 10.01.23 г., 20:17 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.4.0
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
     * @var PassManDb Database handler
     */
    private PassManDb $db;

    /**
     * @param PassManDb $db Database handler
     */
    public function __construct(PassManDb $db)
    {

        $this->db = $db;
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

        $query = $this->db->fetchAll([], $table);

        if ($query > 0) {
            return count($query);
        } else {
            return 0;
        }
    }

    /**
     * Fetch last X records from table
     *
     * @param array  $columns Array with columns to fetch i.e. ['first_name', 'last_name' ...]
     * @param string $table   Table name
     * @param int    $limit   Records limit
     *
     * @return array|false|int|string
     * @throws Exception
     *
     */
    public function lastXrecords(array $columns, string $table, int $limit = 0)
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $query = $this->db->fetchAll($columns, $table, '', '', 'rowid', 'DESC', '', $limit);

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
    public function topXbyRecords(string $table, int $limit = 0)
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
     * Fetch all records from database into array
     *
     * @param array  $array_of_fields Array of fields to update
     * @param string $table           Table to update
     * @param array  $filter          Array of filters. Example array:('field' => 'value'). If key is customsql,
     *                                it should be an array also like ('customsql' => array('field' = > 'value'))
     * @param string $filter_mode     Filter mode AND or OR. Default is AND
     * @param string $sortfield       Sort field
     * @param string $sortorder       Sort order
     * @param string $group           Group BY field name
     * @param int    $limit           Limit
     * @param int    $offset          Offset
     *
     * @return array|false|int|string
     * @throws Exception
     */
    public function fetchAll(
        array $array_of_fields = [],
        string $table = '',
        array $filter = [],
        string $filter_mode = 'AND',
        string $sortfield = '',
        string $sortorder = '',
        string $group = '',
        int $limit = 0,
        int $offset = 0
    ) {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->fetchAll(
            $array_of_fields,
            $table,
            $filter,
            $filter_mode,
            $sortfield,
            $sortorder,
            $group,
            $limit,
            $offset
        );

        if ($result > 0) {
            return $result;
        } else {
            return -1;
        }
    }

    /**
     * Update record in database
     *
     * @param array  $fields Array of fields to update. Must be with format like [$key => $value]
     * @param string $table  Table to update
     * @param int    $id     ID of the records to update
     *
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     *
     */
    public function update(array $fields, string $table, int $id)
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $sql = 'UPDATE ' . PM_MAIN_DB_PREFIX . $table . ' SET ';
        $i = 0;
        foreach ($fields as $key => $value) {
            $sql .= trim($key) . ' = :' . $key;
            if ($i < count($fields) - 1) {
                $sql .= ' , ';
            }
            $i++;
        }
        $sql .= ' Where rowid = :id';

        $query = $this->db->db->prepare($sql);

        $query->bindParam(':id', $id, PDO::PARAM_INT);

        foreach ($fields as $key => $value) {
            $query->bindValue(':' . $key, $value);
        }

        if (!$this->db->db->inTransaction()) {
            $this->db->db->beginTransaction();
        }

        try {
            $query->execute();
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(get_class($this) . ':: record with id=' . $id . ' from ' . $table . 'was updated', PM_LOG_INFO);
            }
            $this->db->db->commit();

            return 1;
        } catch (PDOException $e) {
            $this->db->db->rollBack();
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $e->getMessage(), PM_LOG_ERR);
            }

            return $e->getMessage();
        }
    }
}
