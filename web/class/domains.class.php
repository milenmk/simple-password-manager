<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: domains.class.php
 *  Last Modified: 28.12.22 г., 1:09 ч.
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
 * \file        class/domains.class.php
 * \brief       This file is a CRUD class file for ff (Create/Read/Update/Delete)
 */
class domains
{

	public $conn;
	public $id;
	public $label;
	public $website;
	public $ftp;
	public $data_base;
	public $fk_user;

	public $error;

	public $table_element = 'domains';

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
		(label, website, ftp, data_base, fk_user) 
		VALUES(:label, :website, :ftp, :data_base, :fk_user)'
		);

		$sql->bindValue(':label', $this->label);
		$sql->bindValue(':website', $this->website, PDO::PARAM_INT);
		$sql->bindValue(':ftp', $this->ftp, PDO::PARAM_INT);
		$sql->bindValue(':data_base', $this->data_base, PDO::PARAM_INT);
		$sql->bindParam(':fk_user', $this->fk_user, PDO::PARAM_INT);

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

		$sql = $this->conn->prepare('DELETE FROM ' . MAIN_DB_PREFIX . 'records WHERE fk_domain = :id');
		$sql->bindParam(':id', $this->id, PDO::PARAM_INT);

		if (!$this->conn->inTransaction()) {
			$this->conn->beginTransaction();
		}

		try {
			$sql->execute();
			$this->conn->commit();

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
		catch (Exception $e) {
			$this->conn->rollBack();

			$this->error = $e->getMessage();

			return -2;
		}
	}

	/**
	 * Update record in database
	 *
	 * @return int
	 */
	public function update()
	{

		$sql = $this->conn->prepare('UPDATE ' . MAIN_DB_PREFIX . $this->table_element . ' SET label = :label, website = :website, ftp = :ftp, data_base = :data_base WHERE rowid = :id');
		$sql->bindValue(':label', $this->label);
		$sql->bindValue(':website', $this->website, PDO::PARAM_INT);
		$sql->bindValue(':ftp', $this->ftp, PDO::PARAM_INT);
		$sql->bindValue(':data_base', $this->data_base, PDO::PARAM_INT);
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
	 * Load object from database
	 *
	 * @param int    $id           Record id
	 * @param string $sortorder    Sort order
	 * @param string $sortfield    Sort field
	 * @param int    $limit        Limit
	 * @param string $search_label String to search
	 *
	 * @return array|int
	 */
	public function fetch($user, $id = '', $sortorder = '', $sortfield = '', $limit = 0, $search_label = '')
	{

		$search = '';
		$sort = '';
		$lim = '';

		if (!empty($id)) {
			$where = ' WHERE rowid = :id AND fk_user = :fk_user';
		} else {
			$where = ' WHERE 1 = 1 AND fk_user = :fk_user';
		}
		if (!empty($search_label)) {
			$search = ' AND label LIKE "%' . $search_label . '%"';
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
			'SELECT rowid as id, label, website, ftp, data_base 
		FROM ' . MAIN_DB_PREFIX . $this->table_element . ' ' . $where . ' ' . $search . ' ' . $sort . ' ' . $lim
		);

		if (!empty($id)) {
			$sql->bindParam(':id', $id, PDO::PARAM_INT);
		}
		$sql->bindParam(':fk_user', $user, PDO::PARAM_INT);

		if (!$this->conn->inTransaction()) {
			$this->conn->beginTransaction();
		}

		try {
			$sql->execute();
			$result = $sql->fetchAll(PDO::FETCH_CLASS, 'domains');
			if ($result) {
				return $result;
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