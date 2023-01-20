<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Config.php
 *  Last Modified: 19.01.23 г., 22:46 ч.
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

use PDO;

/**
 * Class for config
 */
abstract class Config
{
    /**
     * @var array Array of config data
     */
    private array $configData;

    /**
     * @var PDO Database connection
     */
    private PDO $conn;

    public function __construct()
    {

        // include the config file
        if (file_exists('../conf/conf.php')) {
            include_once '../conf/conf.php';
        } elseif (file_exists('../../conf/conf.php')) {
            include_once '../../conf/conf.php';
        }

        // Define the config data
        $this->configData = [
            'host'                   => $db_host,
            'port'                   => (int)$db_port,
            'dbname'                 => $db_name,
            'dbprefix'               => $db_prefix,
            'dbuser'                 => $db_user,
            'dbpass'                 => $db_pass,
            'db_character_set'       => $main_db_character_set,
            'db_collation'           => $main_db_collation,
            'main_url_root'          => $main_url_root,
            'main_app_root'          => $main_app_root,
            'main_application_title' => $main_application_title,
        ];

        //Connect to database and initialize global options and constants
        // For code consistency, all constants must be of type PM_*
        // with value 0 or 1 (false/true)
        $this->conn = new PDO(
            'mysql:host=' . $this->configData['host'] . ';
                dbname=' . $this->configData['dbname'] . ';
                port=' . $this->configData['port'],
            $this->configData['dbuser'],
            $this->configData['dbpass']
        );

        $sql = 'SELECT name, value from ' . $this->configData['dbprefix'] . 'options';
        $query = $this->conn->prepare($sql);

        if (!$this->conn->inTransaction()) {
            $this->conn->beginTransaction();
        }

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            foreach ($result as $res) {
                if ($res['value'] == 0) {
                    define($res['name'], false);
                } elseif ($res['value'] == 1) {
                    define($res['name'], true);
                } else {
                    define($res['name'], $res['value']);
                }
            }
        }

        define('PM_MAIN_URL_ROOT', $this->configData['main_url_root']);
        define('PM_MAIN_APP_ROOT', $this->configData['main_app_root']);
        define('PM_MAIN_APPLICATION_TITLE', $this->configData['main_application_title']);
        define('PM_MAIN_DB_PREFIX', $this->configData['dbprefix']);

        return $this;
    }

    /**
     * @return array
     */
    public function getConfigData(): array
    {

        return $this->configData ?? [];
    }
}
