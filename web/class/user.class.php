<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: user.class.php
 *  Last Modified: 28.12.22 г., 1:01 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0
 * @version       1.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 **/

declare(strict_types = 1);

/**
 * \file        class/user.class.php
 * \brief       This file is a CRUD class file for ff (Create/Read/Update/Delete)
 */
class user
{

	public $conn;
	public $id;
	public $first_name;
	public $last_name;
	public $username;
	public $password;
	public $num;
	public $theme;
	public $language;

	public $error;

	public $table_element = 'users';

	public function __construct()
	{

		global $conn;

		$this->conn = $conn;
	}

	/**
	 * Create record in database
	 *
	 * @return int
	 */
	public function create()
	{

		$sql = $this->conn->prepare(
			'INSERT INTO ' . MAIN_DB_PREFIX . $this->table_element . ' 
		(first_name, last_name, username, password, theme, language) 
		VALUES(:first_name, :last_name, :username, :password, :theme, :language)'
		);

		$sql->bindValue(':first_name', $this->first_name);
		$sql->bindValue(':last_name', $this->last_name);
		$sql->bindParam(':username', $this->username, PDO::PARAM_STR, 128);
		$sql->bindParam(':password', $this->password, PDO::PARAM_STR, 128);

		$theme = $this->theme ? : 'default';
		$language = $this->language ? : 'en_US';

		$sql->bindParam(':theme', $theme, PDO::PARAM_STR, 50);
		$sql->bindParam(':language', $language, PDO::PARAM_STR, 8);

		if (!$this->conn->inTransaction()) {
			$this->conn->beginTransaction();
		}

		try {
			$sql->execute();
			$this->conn->commit();

			return 1;
		}
		catch (Exception $e) {
			$this->conn->rollBack();

			$this->error = $e->getMessage();

			return -1;
		}
	}

	/**
	 * Delete record from database
	 *
	 * @return int
	 */
	public function delete()
	{

		$sql = $this->conn->prepare('DELETE FROM ' . MAIN_DB_PREFIX . $this->table_element . ' WHERE rowid = :id');
		$sql->bindParam(':id', $this->id, PDO::PARAM_INT);

		if (!$this->conn->inTransaction()) {
			$this->conn->beginTransaction();
		}

		try {
			$sql->execute();
			$this->conn->commit();

			return 1;
		}
		catch (Exception $e) {
			$this->conn->rollBack();

			$this->error = $e->getMessage();

			return -1;
		}
	}

	/**
	 * Update record in database
	 *
	 * @return int
	 */
	public function update()
	{

		$sql = $this->conn->prepare(
			'UPDATE ' . MAIN_DB_PREFIX . $this->table_element . ' 
		SET first_name = :first_name, last_name = :last_name, username = :username, 
		password = :password, theme = :theme, language = :language WHERE rowid = :id'
		);

		$sql->bindValue(':first_name', $this->first_name);
		$sql->bindValue(':last_name', $this->last_name);
		$sql->bindValue(':username', $this->username);
		$sql->bindValue(':password', $this->password);
		$sql->bindParam(':id', $this->id, PDO::PARAM_INT);
		$sql->bindParam(':theme', $this->theme, PDO::PARAM_STR, 50);
		$sql->bindParam(':language', $this->language, PDO::PARAM_STR, 8);

		if (!$this->conn->inTransaction()) {
			$this->conn->beginTransaction();
		}

		try {
			$sql->execute();
			$this->conn->commit();

			return 1;
		}
		catch (Exception $e) {
			$this->conn->rollBack();

			$this->error = $e->getMessage();

			return -1;
		}
	}

	/**
	 * Load object from database
	 *
	 * @param int    $id        Record id
	 * @param string $sortorder Sort order
	 * @param string $sortfield Sort field
	 * @param int    $limit     Limit
	 *
	 * @return int
	 */
	public function fetch($id = '', $sortorder = '', $sortfield = '', $limit = 0, $search_label = '')
	{

		$search = '';
		$sort = '';
		$lim = '';

		if (!empty($id)) {
			$where = ' WHERE rowid = :id';
		} else {
			$where = ' WHERE 1 = 1';
		}
		if (!empty($search_label)) {
			$search = ' AND username LIKE "%' . $search_label . '%"';
		}
		if (!empty($sortfield)) {
			$sort = ' ORDER BY ' . $sortfield;
		}
		if (!empty($sortorder)) {
			$sort = ' DESC';
		}
		if (!empty($limit)) {
			$lim = ' LIMIT ' . $limit;
		}

		$sql = $this->conn->prepare(
			'SELECT rowid as id, first_name, last_name, username, password, language, theme 
		FROM ' . MAIN_DB_PREFIX . $this->table_element . ' ' . $where . ' ' . $search . ' ' . $sort . ' ' . $lim
		);

		if (!empty($id)) {
			$sql->bindParam(':id', $id, PDO::PARAM_INT);
		}

		if (!$this->conn->inTransaction()) {
			$this->conn->beginTransaction();
		}

		try {
			$sql->execute();
			$result = $sql->fetchObject('user');
			$this->num = $sql->rowCount();
			if ($result) {
				$this->id = $result->id;
				$this->first_name = $result->first_name;
				$this->last_name = $result->last_name;
				$this->username = $result->username;
				$this->password = $result->password;
				$this->language = $result->language;
				$this->theme = $result->theme;

				return 1;
			} else {
				return -1;
			}
		}
		catch (Exception $e) {
			$this->conn->rollBack();

			$this->error = $e->getMessage();

			return -2;
		}
	}

}