<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 31.12.17
 * Time: 00:48
 */

namespace App\Core\Database;

use PDO;
use PDOException;

class Database
{
    private $config;

    /**
     * @var object PDO
     */
    private $pdo;

    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->connect();
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO($this->config["db"]["dsn"], $this->config["db"]["user"], $this->config["db"]["pass"]);
        } catch (PDOException $e) {
            echo "Connection to Database Failed";
        }
    }
}