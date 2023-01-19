<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Domains.php
 *  Last Modified: 17.01.23 г., 13:12 ч.
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
     * @var PassManDb Database handler
     */
    private PassManDb $db;

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

        $data = [
            'label'     => $this->label,
            'website'   => $this->website,
            'ftp'       => $this->ftp,
            'data_base' => $this->data_base,
            'fk_user'   => $this->fk_user,
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
     * Update record in database
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
            'label' => $this->label,
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
     * Delete record from database
     *
     * @return int 1 if OK, <0 if KO
     * @throws Exception
     */
    public function delete()
    {

        if (empty(DISABLE_SYSLOG)) {
            pm_syslog(__METHOD__ . ' called from ' . get_class($this), PM_LOG_INFO);
        }

        $res = $this->db->fetchAll(
            $this->child_table_element,
            'fk_domain = :fk_domain',
            [':fk_domain' => $this->id]
        );

        if ($res) {
            foreach ($res as $child) {
                $result = $this->db->delete($this->child_table_element, 'rowid = :id', [':id' => (int)$child['rowid']]);
                if ($result < 1) {
                    $_SESSION['PM_ERROR'] = $this->db->error;

                    return -1;
                }
            }
        }

        $delete = $this->db->delete($this->table_element, 'rowid = :id', [':id' => $this->id]);

        if ($delete > 0) {
            return 1;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -2;
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
        $domains = [];
        if ($result) {
            foreach ($result as $row) {
                $domain = new self($this->db);
                $domain->id = (int)$row['rowid'];
                $domain->label = $row['label'];
                if ($row['website']) {
                    $domain->website = (int)$row['website'];
                }
                if ($row['ftp']) {
                    $domain->ftp = (int)$row['ftp'];
                }
                if ($row['data_base']) {
                    $domain->data_base = (int)$row['data_base'];
                }
                $domain->fk_user = (int)$row['fk_user'];
                $domains[] = $domain;
            }

            return $domains;
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
     * @return Domains|int Return Object or <0 on error
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
            $this->label = $result['label'];
            if ($result['website']) {
                $this->website = (int)$result['website'];
            }
            if ($result['ftp']) {
                $this->ftp = (int)$result['ftp'];
            }
            if ($result['data_base']) {
                $this->data_base = (int)$result['data_base'];
            }
            $this->fk_user = (int)$result['fk_user'];

            return $this;
        } else {
            $_SESSION['PM_ERROR'] = $this->db->error;

            return -1;
        }
    }
}
