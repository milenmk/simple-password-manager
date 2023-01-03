<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Records.php
 *  Last Modified: 3.01.23 г., 10:45 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       2.2.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        class/Records.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for Records class (Create/Read/Update/Delete)
 */

declare(strict_types = 1);

namespace PasswordManager;

use Exception;
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
     * @var int
     */
    public int $type;
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
     * @var array Array of fields to fetch from database
     */
    public array $array_of_fields = ['fk_domain', 'type', 'url', 'username', 'pass_crypted', 'fk_user'];

    /**
     * @var string Does the object has Parent class to call values from
     */
    public string $hasParentClass = 'yes';
    /**
     * @var string Name of the parent class table
     */
    public string $parentClass = 'domains';

    /**
     * @var string[] Fields of the parent class to fetch
     */
    public array $parentClassFields = ['label'];

    /**
     * @var PassManDb Database handler
     */
    private PassManDb $db;

    /**
     * @param PassManDb $db
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
    public function create(): int
    {

        pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

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
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */
    public function update(): int
    {

        pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

        $array_to_update = [];
        foreach ($this->array_of_fields as $field) {
            if (isset($this->$field) && $this->$field != 0 || !empty($this->$field)) {
                $array_to_update[$field] = $this->$field;
            }
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
    public function delete(): int
    {

        pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

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
     * @return int
     * @throws PDOException|Exception
     */
    public function fetchAll($filter = '', string $filter_mode = 'AND', string $sortfield = '', string $sortorder = '', string $group = '', int $limit = 0, int $offset = 0): int
    {

        pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

        $result = $this->db->fetchAll(
            $this->array_of_fields,
            $this->table_element,
            $filter,
            $filter_mode,
            $sortfield,
            $sortorder,
            $group,
            $limit,
            $offset,
            $this->hasParentClass,
            $this->parentClass,
            $this->parentClassFields,
            'fk_domain'
        );

        if ($result > 0) {
            return $result;
        } else {
            return -1;
        }
    }

    /**
     *
     * Fetch single row from database
     *
     * @param        $id
     * @param string $filter          Array of filters. Example array:('field' => 'value'). If key is customsql,
     *                                it should be an array also like ('customsql' => array('field' = > 'value'))
     * @param string $filter_mode     Filter mode AND or OR. Default is AND
     * @param string $sortfield       Sort field
     * @param string $sortorder       Sort order
     * @param string $group           Group BY field name
     * @param int    $limit           Limit
     * @param int    $offset          Offset
     *
     * @return int
     * @throws Exception
     */
    public function fetch($id, string $filter = '', string $filter_mode = 'AND', string $sortfield = '', string $sortorder = '', string $group = '', int $limit = 0, int $offset = 0): int
    {

        pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

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
            $offset,
            $this->hasParentClass,
            $this->parentClass,
            $this->parentClassFields,
            'fk_domain'
        );

        if ($result > 0) {
            return $result;
        } else {
            return -1;
        }
    }

}
