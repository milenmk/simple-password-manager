<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: PassManDb.php
 *  Last Modified: 3.01.23 г., 11:58 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.3.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        class/PassManDb.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for PassManDb class (Create/Read/Update/Delete)
 */

declare(strict_types=1);

namespace PasswordManager;

use Exception;
use PDO;
use PDOException;

/**
 * Class for database handling
 */
class PassManDb
{
    /**
     * @var string Holds error messages for output
     */
    public $error;
    /**
     * @var array Used to store multiple errors for output
     */
    public array $errors;
    /**
     * @var PDO Database connection
     */
    public PDO $db;
    /**
     * @var string
     */
    private string $forcecharset;
    /**
     * @var string
     */
    private string $forcecollate;
    /**
     * @var string
     */
    private string $database_user;
    /**
     * $var string
     */
    private string $database_password;
    /**
     * @var string
     */
    private string $database_host;
    /**
     * @var int
     */
    private int $database_port;
    /**
     * @var int
     */
    private int $transaction_opened;
    /**
     * @var bool
     */
    private bool $connected;
    /**
     * @var bool
     */
    private bool $ok;
    /**
     * @var bool
     */
    private bool $database_selected;
    /**
     * @var string
     */
    private string $database_name;

    /**
     *    Constructor.
     *    This creates an opened connexion to a database server and eventually to a database
     *
     * @param string $host Address of database server
     * @param string $user Authorized username
     * @param string $pass Password
     * @param string $name Name of database
     * @param int    $port Port of database server
     *
     * @throws PDOException|Exception
     */
    public function __construct(string $host = '', string $user = '', string $pass = '', string $name = '', int $port = 0)
    {

        global $config, $langs;
        // Note that having "static" property for "$forcecharset" and "$forcecollate" will make error here in strict mode, so they are not static
        if (empty($config->db_character_set)) {
            $this->forcecharset = 'utf8';
        } else {
            $this->forcecharset = $config->db_character_set;
        }
        if (!empty($config->db_collation)) {
            $this->forcecollate = $config->db_collation;
        } else {
            $this->forcecollate = 'utf8_general_ci';
        }

        $this->database_user = !$user ? $config->dbuser : $user;
        $this->database_password = !$pass ? $config->dbpass : $pass;
        $this->database_host = !$host ? $config->host : $host;
        $this->database_port = !$port ? $config->port : $port;
        $this->transaction_opened = 0;
        if (!$host) {
            $this->connected = false;
            $this->ok = false;
            $this->error = $langs->trans('ErrorWrongHostParameter');
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ': Connect error, wrong host parameters', PM_LOG_ERR);
            }

            return -1;
        }

        // Try server connection
        $this->db = $this->connect($this->database_host, $this->database_user, $this->database_password, '', $this->database_port);
        if ($this->error) {
            $this->connected = false;
            $this->ok = false;
            if (isset($this->db) && $this->db->errorCode()) {
                $this->error = $this->db->errorInfo();
            } elseif (isset($this->db) && $this->db->errorCode()) {
                $this->error = $this->db->errorCode();
            }

            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ': Connect error: ' . $this->error, PM_LOG_ERR);
            }

            return -2;
        } else {
            $this->connected = true;
            $this->ok = true;
            // set the PDO error mode to exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        // If server connection is ok, we try to connect to the database
        if ($name) {
            if ($this->selectDb($this->database_host, $this->database_user, $this->database_password, $name, $this->forcecharset, $this->forcecollate, $this->database_port)) {
                $this->database_selected = true;
                $this->database_name = $name;
                $this->ok = true;
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return 2;
            } else {
                $this->database_selected = false;
                $this->database_name = '';
                $this->ok = false;
                if (isset($this->db) && $this->db->errorCode()) {
                    $this->error = $this->db->errorInfo();
                } elseif (isset($this->db) && $this->db->errorCode()) {
                    $this->error = $this->db->errorCode();
                }
                if (emptyPM_DISABLE_SYSLOG) {
                    pm_syslog(get_class($this) . ': Select_db error ' . $this->error, PM_LOG_ERR);
                }

                return -3;
            }
        } else {
            return 1;
        }
    }

    /**
     * @param string $host   Database server host
     * @param string $login  Login
     * @param string $passwd Password
     * @param string $name   Name of database (not used for mysql, used for pgsql)
     * @param int    $port   Port of database server
     *
     * @return PDO|void
     * @throws PDOException|Exception
     */
    public function connect(string $host, string $login, string $passwd, string $name, int $port = 0)
    {

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$name;port=$port", $login, $passwd);

            return $this->db;
        } catch (PDOException $e) {
            $this->error = 'Connection failed: ' . $e->getMessage();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog('ERROR: ' . $this->error . ' for method ' . __METHOD__ . ' in class ' . get_class($this), PM_LOG_ERR);
            }
        }
    }

    /**
     *  Select a database
     *
     * @param string $host      Database server host
     * @param string $login     Login
     * @param string $passwd    Password
     * @param string $name      Name of database (not used for mysql, used for pgsql)
     * @param int    $port      Port of database server
     * @param string $charset   Database charset
     * @param string $collation Database collation
     *
     * @return int|PDO            true if OK, false if KO
     * @throws PDOException|Exception
     */
    public function selectDb(string $host, string $login, string $passwd, string $name, string $charset, string $collation, int $port = 0)
    {

        if (emptyPM_DISABLE_SYSLOG) {
            pm_syslog(get_class($this) . '::select_db database=' . $name, PM_LOG_INFO);
        }

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$name;port=$port;charset=$charset;collation=$collation", $login, $passwd);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->db;
        } catch (PDOException $e) {
            $this->error = 'Connection failed: ' . $e->getMessage();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog('ERROR: ' . $this->error . ' for method construct in class ' . get_class($this), PM_LOG_ERR);
            }

            return -1;
        }
    }

    /**
     * Insert record into database
     *
     * @param array  $array_of_fields Array of fields and their values
     * @param string $table_element   Table name
     *
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */
    public function create(array $array_of_fields, string $table_element)
    {

        $sql = 'INSERT INTO ' . PM_MAIN_DB_PREFIX . $table_element . '(';
        foreach ($array_of_fields as $key => $value) {
            $sql .= $key . ', ';
        }
        $sql = preg_replace('/,\s*$/', '', $sql);
        $sql .= ') VALUES (';
        foreach ($array_of_fields as $key => $value) {
            $sql .= ':' . $key . ', ';
        }
        $sql = preg_replace('/,\s*$/', '', $sql);
        $sql .= ')';
        if (emptyPM_DISABLE_SYSLOG) {
            pm_syslog('query:: sql = ' . $sql, PM_LOG_DEBUG);
        }
        $query = $this->db->prepare($sql);
        foreach ($array_of_fields as $key => $value) {
            $query->bindValue(':' . $key, $value);
        }

        if (!$this->db->inTransaction()) {
            $this->db->beginTransaction();
        }

        try {
            $result = $query->execute();
            if ($result) {
                if (emptyPM_DISABLE_SYSLOG) {
                    pm_syslog(get_class($this) . ':: record with id=' . $this->db->lastInsertId() . ' inserted into ' . $table_element, PM_LOG_INFO);
                }
                $this->db->commit();

                return 1;
            } else {
                $this->db->rollBack();
                if (emptyPM_DISABLE_SYSLOG) {
                    pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
                }

                return -1;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }

            return $this->error;
        }
    }

    /**
     * Update record in database
     *
     * @param array  $filter        Array of fields to update. Example array:('field' => 'value').
     * @param string $table_element Table name
     * @param int    $record_id     ID of the record to update
     *
     * @return int
     * @throws PDOException|Exception
     */
    public function update(array $filter, string $table_element, int $record_id)
    {

        $sql = 'UPDATE ' . PM_MAIN_DB_PREFIX . $table_element . ' SET ';
        foreach ($filter as $key => $value) {
            $sql .= $key . ' = :' . $key . ', ';
        }
        $sql = preg_replace('/,\s*$/', '', $sql);
        $sql .= ' WHERE rowid = :id';
        if (emptyPM_DISABLE_SYSLOG) {
            pm_syslog('query:: sql = ' . $sql, PM_LOG_DEBUG);
        }
        $query = $this->db->prepare($sql);
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                $query->bindValue(':' . $key, $value);
            }
        }
        $query->bindParam(':id', $record_id, PDO::PARAM_INT);
        if (!$this->db->inTransaction()) {
            $this->db->beginTransaction();
        }

        try {
            $query->execute();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ':: record with id=' . $this->db->lastInsertId() . ' from ' . $table_element . 'was updated', PM_LOG_INFO);
            }
            $this->db->commit();

            return 1;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }

            return $this->error;
        }
    }

    /**
     * Delete record from database
     *
     * @param string $table_element Table name
     * @param int    $record_id     ID of the record to delete
     *
     * @return int
     * @throws PDOException|Exception
     */
    public function delete(string $table_element, int $record_id)
    {

        $sql = 'DELETE FROM ' . PM_MAIN_DB_PREFIX . $table_element . ' WHERE rowid = :id';
        if (emptyPM_DISABLE_SYSLOG) {
            pm_syslog('query:: sql = ' . $sql, PM_LOG_DEBUG);
        }
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $record_id, PDO::PARAM_INT);
        if (!$this->db->inTransaction()) {
            $this->db->beginTransaction();
        }

        try {
            $query->execute();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ':: record with id=' . $this->db->lastInsertId() . ' from ' . $table_element . 'was deleted', PM_LOG_INFO);
            }
            $this->db->commit();

            return 1;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }

            return $this->error;
        }
    }

    /**
     * Fetch all records from database into array
     *
     * @param array  $array_of_fields      Array of fields to fetch from database
     * @param string $table_element        Table name
     * @param array  $filter               Array of filters. Example array:('field' => 'value'). If key is customsql,
     *                                     it should be an array also like ('customsql' => array('field' = > 'value'))
     * @param string $filter_mode          Filter mode AND or OR. Default is AND
     * @param string $sortfield            Sort field
     * @param string $sortorder            Sort order
     * @param string $group                Group BY field name
     * @param int    $limit                Limit
     * @param int    $offset               Offset
     * @param string $hasParent            Does the object has Parent class to call values from
     * @param string $parentClassTable     Name of the parent class
     * @param array  $parentClassFields    Fields of the parent class to fetch
     * @param string $childClassField      Child class field that matches parent ID
     *
     * @return array|false|string
     * @throws PDOException|Exception
     */
    public function fetchAll(array $array_of_fields, string $table_element, $filter = '', string $filter_mode = 'AND', string $sortfield = '', string $sortorder = '', string $group = '', int $limit = 0, int $offset = 0, string $hasParent = '', string $parentClassTable = '', $parentClassFields = '', string $childClassField = '')
    {

        $sql = 'Select t.rowid as id,';
        if (is_iterable($array_of_fields)) {
            foreach ($array_of_fields as $key) {
                $sql .= ' t.' . $key . ', ';
            }
        }

        if ($hasParent) {
            foreach ($parentClassFields as $key) {
                $sql .= ' p.' . $key . ', ';
            }
        }
        $sql = preg_replace('/,\s*$/', '', $sql);
        $sql .= ' FROM ' . PM_MAIN_DB_PREFIX . $table_element . ' as t';
        if ($hasParent) {
            $sql .= ' INNER JOIN ' . PM_MAIN_DB_PREFIX . $parentClassTable . ' as p ON t.' . $childClassField . ' = p.rowid';
        }
        $sql .= ' Where 1 = 1';
        $search_user = 0;
        $user_key = '';
        $user_value = '';
        $sqlwhere = [];
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if ($key == 'fk_user') {
                    $search_user = 1;
                    $user_key = $key;
                    $user_value = $value;
                } elseif ($key == 'rowid' || $key == 'id') {
                    $sqlwhere[] = 't.rowid = :' . $key;
                } elseif ($key == 'customsql') {
                    foreach ($value as $field => $val) {
                        $sqlwhere[] = 't.' . $field . ' = :' . $field;
                    }
                } else {
                    $sqlwhere[] = 't.' . $key . ' LIKE :' . $key;
                }
            }
        }
        if ($search_user > 0) {
            $sql .= ' AND t.' . $user_key . ' = :' . $user_key;
        }
        if (!empty($sqlwhere)) {
            $sql .= ' AND (' . implode(' ' . $filter_mode . ' ', $sqlwhere) . ')';
        }
        if (!empty($group)) {
            $sql .= ' GROUP BY ' . $group;
        }
        if (!empty($sortfield)) {
            $sql .= ' ORDER BY ' . $sortfield . ' ' . $sortorder;
        }
        if (!empty($limit)) {
            $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        }

        if (emptyPM_DISABLE_SYSLOG) {
            pm_syslog('query:: sql = ' . $sql, PM_LOG_DEBUG);
        }
        $query = $this->db->prepare($sql);
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if ($key == 'fk_user') {
                    $query->bindValue(':' . $user_key, $user_value);
                } elseif ($key == 'rowid' || $key == 'id') {
                    $query->bindValue(':' . $key, $value);
                } elseif ($key == 'customsql') {
                    foreach ($value as $field => $val) {
                        $query->bindValue(':' . $field, $val);
                    }
                } else {
                    $query->bindValue(':' . $key, "%$value%");
                }
            }
        }

        if (!$this->db->inTransaction()) {
            $this->db->beginTransaction();
        }

        try {
            $query->execute();

            return $query->fetchAll();
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }

            return $this->error;
        }
    }

    /**
     *
     * Fetch single row from database
     *
     * @param int    $id                   ID of the record to fetch
     * @param array  $array_of_fields      Array of fields to fetch from database
     * @param string $table_element        Table name
     * @param array  $filter               Array of filters. Example array:('field' => 'value'). If key is customsql,
     *                                     it should be an array also like ('customsql' => array('field' = > 'value'))
     * @param string $filter_mode          Filter mode AND or OR. Default is AND
     * @param string $sortfield            Sort field
     * @param string $sortorder            Sort order
     * @param string $group                Group BY field name
     * @param int    $limit                Limit
     * @param int    $offset               Offset
     * @param string $hasParent            Does the object has Parent class to call values from
     * @param string $parentClassTable     Name of the parent class
     * @param array  $parentClassFields    Fields of the parent class to fetch
     * @param string $childClassField      Child class field that matches parent ID
     *
     * @return array|int
     * @throws PDOException|Exception
     */
    public function fetch($id = '', array $array_of_fields, string $table_element, $filter = '', string $filter_mode = 'AND', string $sortfield = '', string $sortorder = '', string $group = '', int $limit = 0, int $offset = 0, string $hasParent = '', string $parentClassTable = '', $parentClassFields = '', string $childClassField = '')
    {

        $sql = 'Select t.rowid as id,';
        foreach ($array_of_fields as $key) {
            $sql .= ' t.' . $key . ', ';
        }
        if ($hasParent) {
            foreach ($parentClassFields as $key) {
                $sql .= ' p.' . $key . ', ';
            }
        }
        $sql = preg_replace('/,\s*$/', '', $sql);
        $sql .= ' FROM ' . PM_MAIN_DB_PREFIX . $table_element . ' as t';
        if ($hasParent) {
            $sql .= ' INNER JOIN ' . PM_MAIN_DB_PREFIX . $parentClassTable . ' as p ON t.' . $childClassField . ' = p.rowid';
        }
        if (!empty($id)) {
            $sql .= ' Where 1 = 1 AND t.rowid = :id';
        } else {
            $sql .= ' Where 1 = 1';
        }

        $sqlwhere = [];
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if ($key == 'rowid' || $key == 'id') {
                    $sqlwhere[] = 't.rowid = :' . $key;
                } elseif ($key == 'customsql') {
                    foreach ($value as $field => $val) {
                        $sqlwhere[] = 't.' . $field . ' = :' . $field;
                    }
                } else {
                    $sqlwhere[] = 't.' . $key . ' = :' . $key;
                }
            }
        }
        if (!empty($sqlwhere)) {
            $sql .= ' AND (' . implode(' ' . $filter_mode . ' ', $sqlwhere) . ')';
        }
        if (!empty($group)) {
            $sql .= ' GROUP BY ' . $group;
        }
        if (!empty($sortfield)) {
            $sql .= ' ORDER BY ' . $sortfield . ' ' . $sortorder;
        }
        if (!empty($limit)) {
            $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        }

        if (emptyPM_DISABLE_SYSLOG) {
            pm_syslog('query:: sql = ' . $sql, PM_LOG_DEBUG);
        }
        $query = $this->db->prepare($sql);
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if ($key == 'rowid' || $key == 'id') {
                    $query->bindValue(':' . $key, $value);
                } elseif ($key == 'customsql') {
                    foreach ($value as $field => $val) {
                        $query->bindValue(':' . $field, $val);
                    }
                } else {
                    $query->bindValue(':' . $key, $value);
                }
            }
        }

        if (!empty($id)) {
            $query->bindParam(':id', $id, PDO::PARAM_INT);
        }

        if (!$this->db->inTransaction()) {
            $this->db->beginTransaction();
        }

        try {
            $query->execute();

            return $query->fetch();
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (emptyPM_DISABLE_SYSLOG) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }

            return $this->error;
        }
    }
}
