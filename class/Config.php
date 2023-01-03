<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Config.php
 *  Last Modified: 3.01.23 г., 10:41 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.2.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        class/Config.php
 * \ingroup     Password Manager
 * \brief       This file is a config file for config class
 */

declare(strict_types = 1);

namespace PasswordManager;

/**
 * Class for config
 */
class Config
{
    /**
     * @var string Database host
     */
    public string $host;
    /**
     * @var int Database port
     */
    public int $port;

    /**
     * @var string Database name
     */
    public string $dbname;

    /**
     * @var string Database tables prefix
     */
    public string $dbprefix;

    /**
     * @var string Database username
     */
    public string $dbuser;

    /**
     * @var string Database user password
     */
    public string $dbpass;

    /**
     * @var string Database character set
     */
    public string $db_character_set;

    /**
     * @var string Database collation
     */
    public string $db_collation;
    /**
     * @var string
     */
    public string $main_url_root;
    /**
     * @var string
     */
    public string $main_app_root;
    /**
     * @var string
     */
    public string $main_application_title;

    public function __construct()
    {

        include_once '../conf/conf.php';

        //Define database variables from conf file
        $this->host = $db_host;
        $this->port = (int)$db_port;
        $this->dbname = $db_name;
        $this->dbprefix = $db_prefix;
        $this->dbuser = $db_user;
        $this->dbpass = $db_pass;
        $this->db_character_set = $main_db_character_set;
        $this->db_collation = $main_db_collation;
        $this->main_url_root = $main_url_root;
        $this->main_app_root = $main_app_root;
        $this->main_application_title = $main_application_title;

        return $this;
    }
}
