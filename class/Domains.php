<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Domains.php
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
 * \file        class/Domains.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for Domains class (Create/Read/Update/Delete)
 */

declare(strict_types=1);

namespace PasswordManager;

use Exception;
use PDOException;

/**
 * Class for domains
 */
class Domains
{
    /**
     * @var int Object id
     */
    public int $id;
    /**
     * @var string Object label
     */
    public string $label;
    /**
     * @var int has website record(s)?
     */
    public int $website;
    /**
     * @var int has FTP record(s)?
     */
    public int $ftp;
    /**
     * @var int has Database record(s)?
     */
    public int $data_base;
    /**
     * @var int User who owns
     */
    public int $fk_user;
    /**
     * @var string Object error handler
     */
    public string $error;
    /**
     * @var int Number of affected rows
     */
    public int $num;

    /**
     * @var string Name of table without prefix where object is stored.
     */
    public string $table_element = 'domains';

    /**
     * @var string Name of the child table, without prefix, to delete child records.
     */
    public string $child_table_element = 'records';

    /**
     * @var array Array of fields to fetch from database
     */
    public array $array_of_fields = ['label', 'website', 'ftp', 'data_base', 'fk_user'];

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
        $array = [];
        foreach ($this->array_of_fields as $val) {
            if (!empty($this->$val)) {
                $array[$val] = $this->$val;
            }
        }

        $result = $this->db->create($array, $this->table_element);

        if ($result > 0) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Update record in database
     *
     * @param array $fields Array fo fields to update
     *
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */
    public function update(array $fields)
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }
        $array_to_update = [];
        foreach ($fields as $field) {
            $array_to_update[$field] = $this->$field;
        }

        $result = $this->db->update($array_to_update, $this->table_element, $this->id);

        if ($result > 0) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Delete record from database
     *
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */
    public function delete()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }
        $res = $this->db->fetchAll([], $this->child_table_element, ['fk_domain' => $this->id], '');

        foreach ($res as $child) {
            $this->db->delete($this->child_table_element, (int)$child['id']);
        }

        $result = $this->db->delete($this->table_element, $this->id);

        if ($result > 0) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Fetch all records from database into array
     *
     * @param array  $filter          Array of filters. Example array:('field' => 'value'). If key is customsql,
     *                                it should be an array also like ('customsql' => array('field' = > 'value'))
     * @param string $filter_mode     Filter mode AND or OR. Default is AND
     * @param string $sortfield       Sort field
     * @param string $sortorder       Sort order
     * @param string $group           Group BY field name
     * @param int    $limit           Limit
     * @param int    $offset          Offset
     *
     * @return int|array|false|string
     * @throws PDOException|Exception
     */
    public function fetchAll(
        $filter = '',
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
            $this->array_of_fields,
            $this->table_element,
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
     * Fetch single row from database
     *
     * @param int    $id              ID of the record to fetch
     * @param array  $filter          Array of filters. Example array:('field' => 'value'). If key is customsql,
     *                                it should be an array also like ('customsql' => array('field' = > 'value'))
     * @param string $filter_mode     Filter mode AND or OR. Default is AND
     * @param string $sortfield       Sort field
     * @param string $sortorder       Sort order
     * @param string $group           Group BY field name
     * @param int    $limit           Limit
     * @param int    $offset          Offset
     *
     * @return int
     * @throws PDOException|Exception
     */
    public function fetch(
        int $id,
        $filter = '',
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

        $result = $this->db->fetch(
            $id,
            $this->array_of_fields,
            $this->table_element,
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
}
