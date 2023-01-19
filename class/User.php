<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: User.php
 *  Last Modified: 17.01.23 г., 14:01 ч.
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
 * \file        class/User.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for User class (Create/Read/Update/Delete)
 */

declare(strict_types=1);

namespace PasswordManager;

use Exception;
use PDOException;

/**
 * Class to manage users
 */
class User
{
    /**
     * @var int User ID
     */
    public int $id;
    /**
     * @var string User first name
     */
    public string $first_name;
    /**
     * @var string User last name
     */
    public string $last_name;
    /**
     * @var string user email address
     */
    public string $username;
    /**
     * @var string user date of creation
     */
    public string $created_at;
    /**
     * @var string user theme
     */
    public string $theme;
    /**
     * @var string user language
     */
    public string $language;
    /**
     * @var int 1 if user is admin and 0 if not
     */
    public int $admin;
    /**
     * @var string Error
     */
    public string $error;
    /**
     * @var string Message
     */
    public string $message;
    /**
     * @var string user password
     */
    public string $password;
    /**
     * @var PassManDb DB Handler
     */
    private PassManDb $db;

    /**
     * @var string Database table name
     */
    private string $table_element = 'users';

    /**
     *    Constructor of the class
     *
     * @param PassManDb $db Database handler
     */
    public function __construct(PassManDb $db)
    {

        $this->db = $db;
        $this->db->error = '';
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

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $data = [
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'username'   => $this->username,
            'password'   => $this->password,
        ];
        $result = $this->db->create($this->table_element, $data);

        if ($result > 0) {
            return 1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * Update user data
     *
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */
    public function update()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $data = [
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'username'   => $this->username,
            'theme'      => $this->theme,
            'language'   => $this->language,
        ];
        if (!empty($this->password)) {
            $data['password'] = password_hash($this->password, PASSWORD_DEFAULT);
        }

        $result = $this->db->update($this->table_element, $data, "rowid = $this->id");

        if ($result > 0) {
            return 1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * Delete a user
     *
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     */
    public function delete()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->delete($this->table_element, 'rowid = :id', [':id' => $this->id]);

        if ($result > 0) {
            return 1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
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
        $users = [];
        if ($result) {
            foreach ($result as $row) {
                $user = new self($this->db);
                $user->id = (int)$row['rowid'];
                if ($result['first_name']) {
                    $user->first_name = $result['first_name'];
                }
                if ($result['last_name']) {
                    $user->last_name = $result['last_name'];
                }
                $user->username = $row['username'];
                if ($row['theme']) {
                    $user->theme = $row['theme'];
                }
                if ($row['language']) {
                    $user->language = $row['language'];
                }
                if ($row['admin']) {
                    $user->admin = (int)$row['admin'];
                }
                $users[] = $user;
            }

            return $users;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * Check if user exist
     *
     * @param string $username
     *
     * @return int User id if OK, <0 if KO
     * @throws Exception
     */
    public function userExist(string $username)
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->fetch($this->table_element, 'username = :username', [':username' => $username]);

        if ($result) {
            return (int)$result['rowid'];
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
     * @return User|int Return Object or <0 on error
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
            if ($result['first_name']) {
                $this->first_name = $result['first_name'];
            }
            if ($result['last_name']) {
                $this->last_name = $result['last_name'];
            }
            $this->username = $result['username'];
            if ($result['theme']) {
                $this->theme = $result['theme'];
            }
            if ($result['language']) {
                $this->language = $result['language'];
            }
            if ($result['admin']) {
                $this->admin = (int)$result['admin'];
            }
            $this->password = $result['password'];

            return $this;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * Check if user is admin
     *
     * @param string $username
     *
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     */
    public function isAdmin(string $username)
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->fetch($this->table_element, 'username = :username', [':username' => $username]);
        if ($result && $result['admin'] == 1) {
            return 1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     */
    public function login()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->fetch($this->table_element, 'username = :username', [':username' => $this->username]);

        if ($result && password_verify($this->password, $result['password'])) {
            return 1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * @param string $password user plain password
     *
     * @return void
     */
    public function setPassword(string $password)
    {

        $this->password = $password;
    }

    /**
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     */
    public function updatePassword()
    {
        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $data['password'] = password_hash($this->password, PASSWORD_DEFAULT);

        $result = $this->db->update($this->table_element, $data, "rowid = $this->id");

        if ($result > 0) {
            return 1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }

    /**
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     */
    public function checkPassword()
    {
        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $result = $this->db->fetch($this->table_element, 'username = :username', [':username' => $this->username]);

        if (password_verify($this->password, $result['password'])) {
            return 1;
        } elseif ($result < 1 || empty($result)) {
            return -1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -2;
        }
    }
}
