<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: user.php
 *  Last Modified: 31.12.22 г., 11:59 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       2.1.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        class/user.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for user class (Create/Read/Update/Delete)
 */

declare(strict_types = 1);

namespace PasswordManager;

use Exception;
use PDOException;

/**
 * Class for user
 */
class user
{

    /**
     * @var passManDb Database handler
     */
    private passManDb $db;
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
     * @var string user username, defaults to email address
     */
    public string $username;
    /**
     * @var string User password
     */
    private string $password;
    /**
     * @var int Number of affected rows
     */
    public int $num;
    /**
     * @var string User theme
     */
    public string $theme;
    /**
     * @var string user language
     */
    public string $language;
    /**
     * @var string Error
     */
    public string $error;

    /**
     * @var array Array of fields to fetch from database
     */
    public array $array_of_fields = ['first_name', 'last_name', 'username', 'password', 'created_at', 'theme', 'language'];

    /**
     * @var string Name of table without prefix where object is stored.
     */
    public string $table_element = 'users';

    /**
     *    Constructor of the class
     *
     * @param passManDb $db Database handler
     */
    public function __construct($db)
    {

        $this->db = $db;
    }

    /**
     * Insert record in database
     *
     * @return int 1 if OK, <0 if KO
     * @throws PDOException|Exception
     */

    /**
     * Insert record in database
     *
     * @param string $password Hash password
     *
     * @return int
     * @throws Exception
     */
    public function create($password)
    {

        pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

        $this->password = $password;

        if (empty($this->language)) {
            $this->language = 'en_US';
        }
        if (empty($this->theme)) {
            $this->theme = 'default';
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
     * @param string $password New password
     *
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     */
    public function update($password = '')
    {

        pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

        $this->password = password_hash($password, PASSWORD_DEFAULT);

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
     * @throws Exception
     */
    public function delete()
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
    public function fetchAll($filter = '', $filter_mode = 'AND', $sortfield = '', $sortorder = '', $group = '', $limit = 0, $offset = 0)
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
            $offset
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
     * @param array  $filter          Array of filters. Example array:('field' => 'value'). If key is customsql,
     *                                it should be an array also like ('customsql' => array('field' = > 'value'))
     * @param string $filter_mode     Filter mode AND or OR. Default is AND
     * @param string $sortfield       Sort field
     * @param string $sortorder       Sort order
     * @param string $group           Group BY field name
     * @param int    $limit           Limit
     * @param int    $offset          Offset
     *
     * @return int|array
     * @throws PDOException|Exception
     */
    public function fetch($id = '', $filter = '', $filter_mode = 'AND', $sortfield = '', $sortorder = '', $group = '', $limit = 0, $offset = 0, $password = '')
    {

        pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

        $result = $this->db->fetch($id, $this->array_of_fields, $this->table_element, $filter, $filter_mode, $sortfield, $sortorder, $group, $limit, $offset);

        if ($result > 0) {
            if ($password) {
                if (password_verify($password, $result['password'])) {
                    return $result;
                } else {
                    return -2;
                }
            } else {
                return $result;
            }
        } else {
            return -1;
        }
    }
}
