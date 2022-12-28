<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: records.class.php
 *  Last Modified: 28.12.22 г., 2:07 ч.
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
 * \file        class/records.class.php
 * \brief       This file is a CRUD class file for rec (Create/Read/Update/Delete)
 */
class records
{

	public $conn;
	public $id;
	public $fk_domain;
	public $is_db;
	public $is_site;
	public $is_ftp;
	public $dbase_name;
	public $ftp_server;
	public $url;
	public $username;
	public $password;
	public $pass_crypted;
	public $fk_user;

	public $error;

	public $table_element = 'records';

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

		//TODO: Update table domains to show that there is a record for database, website or url
		if ($this->password) {

			require_once ('../docs/secret.key');

			$this->pass_crypted = openssl_encrypt($this->password, $ciphering, $encryption_key, $options, $encryption_iv);
		}

		$sql = $this->conn->prepare(
			'INSERT INTO ' . MAIN_DB_PREFIX . $this->table_element . ' 
		(fk_domain, is_db, is_site, is_ftp, dbase_name, ftp_server, url, username, pass_crypted, fk_user) 
		VALUES(:fk_domain, :is_db, :is_site, :is_ftp, :dbase_name, :ftp_server, :url, :username, :pass_crypted, :fk_user)'
		);

		$sql->bindValue(':fk_domain', $this->fk_domain, PDO::PARAM_INT);
		$sql->bindValue(':is_db', $this->is_db, PDO::PARAM_INT);
		$sql->bindValue(':is_site', $this->is_site, PDO::PARAM_INT);
		$sql->bindValue(':is_ftp', $this->is_ftp, PDO::PARAM_INT);
		$sql->bindValue(':dbase_name', $this->dbase_name);
		$sql->bindValue(':ftp_server', $this->ftp_server);
		$sql->bindValue(':url', $this->url);
		$sql->bindValue(':username', $this->username);
		$sql->bindValue(':pass_crypted', $this->pass_crypted);
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

		//TODO: Update table domains to remove record type of only one record found

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

		//TODO: Update table domains to show that there is or isn't a record for database, website or url

		if ($this->password) {

			include_once ('../docs/secret.key');

			$this->pass_crypted = openssl_encrypt($this->password, $ciphering, $encryption_key, $options, $encryption_iv);
		}

		$sql = $this->conn->prepare(
			'UPDATE ' . MAIN_DB_PREFIX . $this->table_element . ' 
		SET fk_domain = :fk_domain, is_db = :is_db, is_site = :is_site, is_ftp = :is_ftp, dbase_name = :dbase_name, 
		ftp_server = :ftp_server, url = :url, username = :username, pass_crypted = :pass_crypted WHERE rowid = :id'
		);

		$sql->bindValue(':fk_domain', $this->fk_domain, PDO::PARAM_INT);
		$sql->bindValue(':is_db', $this->is_db, PDO::PARAM_INT);
		$sql->bindValue(':is_site', $this->is_site, PDO::PARAM_INT);
		$sql->bindValue(':is_ftp', $this->is_ftp, PDO::PARAM_INT);
		$sql->bindValue(':dbase_name', $this->dbase_name);
		$sql->bindValue(':ftp_server', $this->ftp_server);
		$sql->bindValue(':url', $this->url);
		$sql->bindValue(':username', $this->username);
		$sql->bindValue(':pass_crypted', $this->pass_crypted);
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
	public function fetch($user, $id = '', $fk_domain = '', $sortorder = '', $sortfield = '', $limit = 0, $search_label = '')
	{

		$search = '';
		$sort = '';
		$lim = '';

		if ($id) {
			$where = ' WHERE rowid = :id AND fk_user = :fk_user';
		} elseif ($fk_domain) {
			$where = ' WHERE fk_domain = :fk_domain AND fk_user = :fk_user';
		} else {
			$where = ' Where 1 = 1 AND fk_user = :fk_user';
		}
		if ($search_label) {
			$search = ' AND dbase_name LIKE "%' . $search_label . '%" 
			OR url LIKE "%' . $search_label . '%" 
			OR ftp_server LIKE "%' . $search_label . '%" 
			OR username LIKE "%' . $search_label . '%"';
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
			'SELECT rowid as line_id, fk_domain, is_db, is_site, is_ftp, dbase_name, ftp_server, url, username, pass_crypted 
			FROM ' . MAIN_DB_PREFIX . $this->table_element . ' ' . $where . ' ' . $search . ' ' . $sort . ' ' . $lim
		);

		if ($id) {
			$sql->bindParam(':id', $id, PDO::PARAM_INT);
		}
		if ($fk_domain) {
			$sql->bindParam(':fk_domain', $fk_domain, PDO::PARAM_INT);
		}
		$sql->bindParam(':fk_user', $user, PDO::PARAM_INT);

		if (!$this->conn->inTransaction()) {
			$this->conn->beginTransaction();
		}

		try {
			$sql->execute();
			$result = $sql->fetchAll(PDO::FETCH_CLASS, 'records');
			if ($result) {
				return $result;
			} else {
				return -1;
			}
		}
		catch (Exception $e) {
			$this->conn->rollBack();

			$this->error = $e->getMessage();

			return -1;
		}
	}

}