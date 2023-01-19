<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: PassManDb.php
 *  Last Modified: 19.01.23 г., 22:11 ч.
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

declare(strict_types=1);

namespace PasswordManager;

use Exception;
use PDO;
use PDOException;

/**
 * CRUD class for database queries
 */
class PassManDb extends Config
{
    /**
     * @var string Holds error messages for output
     */
    public string $error;
    /**
     * @var array Used to store multiple errors for output
     */
    public array $errors;
    /**
     * @var PDO Database connection
     */
    public PDO $db;
    /**
     * @var bool
     */
    public bool $connected;
    /**
     * @var string
     */
    private string $forcecharset;
    /**
     * @var string
     */
    private string $forcecollate;
    /**
     * @var array
     */
    private array $configData;
    /**
     * @var int
     */
    private int $transaction_opened;

    /**
     * @throws Exception
     */
    public function __construct()
    {

        parent::__construct();
        $this->configData = $this->getConfigData();

        if (isset($this->configData['db_character_set'])) {
            $this->forcecharset = $this->configData['db_character_set'];
        } else {
            $this->forcecharset = 'utf8';
        }

        if (isset($this->configData['db_collation'])) {
            $this->forcecollate = $this->configData['db_collation'];
        } else {
            $this->forcecollate = 'utf8_general_ci';
        }

        $this->transaction_opened = 0;

        // Try server connection
        try {
            $this->db = new PDO(
                'mysql:host=' . $this->configData['host'] . ';
                dbname=' . $this->configData['dbname'] . ';
                port=' . $this->configData['port'],
                $this->configData['dbuser'],
                $this->configData['dbpass']
            );
            $this->connected = true;

            return $this->db;
        } catch (PDOException $e) {
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(get_class($this) . ': Connect error: ' . $e->getMessage(), PM_LOG_ERR);
            }
            $_SESSION['PM_ERROR'] = $this->error;

            return -1;
        }
    }

    /**
     * Create a new record in the database
     *
     * @param string $tableName The table to insert into
     * @param array  $data      Key-value pairs of data to insert
     *
     * @return false|int|string The ID of the inserted record or <0 on error
     * @throws Exception
     */
    public function create(string $tableName, array $data)
    {

        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            $query = 'INSERT INTO ' . PM_MAIN_DB_PREFIX . $tableName . ' (' . $columns . ') VALUES (' . $values . ')';
            $stmt = $this->db->prepare($query);
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            if ($stmt->execute()) {
                if (empty(DISABLE_SYSLOG)) {
                    pm_syslog(get_class($this) . ':: record with id=' . $this->db->lastInsertId() . ' inserted into ' . $tableName, PM_LOG_INFO);
                }

                return $this->db->lastInsertId();
            } else {
                $this->db->rollBack();
                if (empty(DISABLE_SYSLOG)) {
                    pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
                }
                $_SESSION['PM_ERROR'] = $this->error;

                return -1;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }
            $_SESSION['PM_ERROR'] = $this->error;

            return -2;
        }
    }

    /**
     * Update a record in the database
     *
     * @param string $tableName The table to update
     * @param array  $data      Key-value pairs of data to update
     * @param string $where     The WHERE clause of the query
     *
     * @return int The number of affected rows or <0 on error
     * @throws Exception
     */
    public function update(string $tableName, array $data, string $where)
    {

        try {
            $set = '';
            foreach ($data as $key => $value) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ', ');
            $query = 'UPDATE ' . PM_MAIN_DB_PREFIX . $tableName . ' SET ' . $set . ' WHERE ' . $where;
            $stmt = $this->db->prepare($query);
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            if ($stmt->execute()) {
                if (empty(DISABLE_SYSLOG)) {
                    pm_syslog(get_class($this) . ':: record where ' . $where . ' from ' . $tableName . 'was updated', PM_LOG_INFO);
                }

                return $stmt->rowCount();
            } else {
                $_SESSION['PM_ERROR'] = $this->error;

                return -1;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }
            $_SESSION['PM_ERROR'] = $this->error;

            return -2;
        }
    }

    /**
     * Delete a record from the database
     *
     * @param string $tableName The table to delete from
     * @param string $where     The WHERE clause of the query
     * @param array  $params    An array of parameters to bind to the query
     *
     * @return int The number of affected rows or <0 on error
     * @throws Exception
     */
    public function delete(string $tableName, string $where, array $params = [])
    {

        try {
            $query = 'DELETE FROM ' . PM_MAIN_DB_PREFIX . $tableName . ' WHERE ' . $where ;
            $stmt = $this->db->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            if ($stmt->execute()) {
                if (empty(DISABLE_SYSLOG)) {
                    pm_syslog(get_class($this) . ':: record with id=' . $params[':id'] . ' from ' . $tableName . 'was deleted', PM_LOG_INFO);
                }

                return $stmt->rowCount();
            } else {
                $_SESSION['PM_ERROR'] = $this->error;

                return -1;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }
            $_SESSION['PM_ERROR'] = $this->error;

            return -2;
        }
    }

    /**
     * Fetch a single record from the database
     *
     * @param string $tableName The table to fetch from
     * @param string $where     The WHERE clause of the query
     * @param array  $params    An array of parameters to bind to the query
     * @param string $other     Other options like GROUP BY, SORT BY, LIMIT, etc.
     *
     * @return int|mixed The fetched record or <0 on error
     * @throws Exception
     */
    public function fetch(string $tableName, string $where, array $params = [], string $other = '')
    {

        try {
            $query = 'SELECT * FROM ' . PM_MAIN_DB_PREFIX . $tableName;
            if ($where) {
                $query .= ' WHERE ' . $where;
            }
            if ($other) {
                $query .= ' ' . $other;
            }
            $stmt = $this->db->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $_SESSION['PM_ERROR'] = $this->error;

                return -1;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }
            $_SESSION['PM_ERROR'] = $this->error;

            return -2;
        }
    }

    /**
     * Fetch multiple records from the database
     *
     * @param string $tableName The table to fetch from
     * @param string $where     The WHERE clause of the query
     * @param array  $params    An array of parameters to bind to the query
     * @param string $other     Other options like GROUP BY, SORT BY, LIMIT, etc.
     *
     * @return array|false|int The fetched records or <0 on error
     * @throws Exception
     */
    public function fetchAll(string $tableName, string $where, array $params = [], string $other = '')
    {

        try {
            $query = 'SELECT * FROM ' . PM_MAIN_DB_PREFIX . $tableName;
            if ($where) {
                $query .= ' WHERE ' . $where;
            }
            if ($other) {
                $query .= ' ' . $other;
            }
            $stmt = $this->db->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $_SESSION['PM_ERROR'] = $this->error;

                return -1;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->error = $e->getMessage();
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(get_class($this) . ':: ' . __METHOD__ . ' error: ' . $this->error, PM_LOG_ERR);
            }
            $_SESSION['PM_ERROR'] = $this->error;

            return -2;
        }
    }
}
