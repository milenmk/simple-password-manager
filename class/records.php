<?php
/**
 * \file        class/records.php
 * \ingroup     Password Manager
 * \brief       This file is a CRUD file for records class (Create/Read/Update/Delete)
 */

declare(strict_types = 1);

namespace PasswordManager;

use Exception;
use PDOException;

/**
 * Class for records
 */
class records
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
	 * @var bool
	 */
	public bool $is_db;
	/**
	 * @var bool
	 */
	public bool $is_site;
	/**
	 * @var bool
	 */
	public bool $is_ftp;
	/**
	 * @var string
	 */
	public string $dbase_name;
	/**
	 * @var string
	 */
	public string $ftp_server;
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
	public string $password;
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
	public array $array_of_fields = ['fk_domain', 'is_db', 'is_site', 'is_ftp', 'dbase_name', 'ftp_server', 'url', 'username', 'pass_crypted', 'fk_user'];

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
	 * @var string
	 */
	public string $label;

	/**
	 * @var passManDb Database handler
	 */
	private passManDb $db;

	/**
	 * @param passManDb $db
	 */
	public function __construct(passManDb $db)
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
	public function update()
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
			$this->array_of_fields, $this->table_element, $filter, $filter_mode, $sortfield, $sortorder, $group, $limit, $offset,
			$this->hasParentClass, $this->parentClass, $this->parentClassFields, 'fk_domain'
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
	 * @return int
	 * @throws PDOException|Exception
	 */
	public function fetch($id, $filter = '', $filter_mode = 'AND', $sortfield = '', $sortorder = '', $group = '', $limit = 0, $offset = 0)
	{

		pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);

		$result = $this->db->fetch(
			$id, $this->array_of_fields, $this->table_element, $filter, $filter_mode, $sortfield, $sortorder, $group, $limit, $offset,
			$this->hasParentClass, $this->parentClass, $this->parentClassFields, 'fk_domain'
		);

		if ($result > 0) {
			return $result;
		} else {
			return -1;
		}
	}

}