<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 31.12.17
 * Time: 00:47
 */

namespace Shirts\Repository;

use Shirts\Model\ShirtModel;

class ShirtRepository
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getShirts($lang = 'en')
    {
        $sql = "SELECT shirts.*, name.value as title, name.language as language FROM shirts JOIN shirts_name as name ON shirts.id = name.shirt AND name.language = :LANG";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':LANG', $lang);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, ShirtModel::class);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function checkShirt($id)
    {
        $sql = "SELECT * FROM shirts WHERE id = :Id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Id', $id);
            $stmt->execute();
            $result = $stmt->rowCount();

            if ($result > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getShirt($id, $lang = "en")
    {
        $sql = "SELECT shirts.*, name.value as title, name.language as language FROM shirts JOIN shirts_name as name ON shirts.id = name.shirt AND name.language = :LANG AND shirts.id = :Id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Id', $id);
            $stmt->bindParam(':LANG', $lang);
            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_CLASS, ShirtModel::class);
            $result = $stmt->fetch(\PDO::FETCH_CLASS);

            return $result;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function saveShirt($data)
    {
        $result = $this->insertShirt($data);
        if ($result) {
            $data["shirt"] = $this->getLastId();
            return $this->insertShirtName($data);
        }

        return false;
    }


    private function insertShirt($data)
    {
        $sql = "INSERT INTO shirts (price, `size`, image) VALUES (:PRICE, :SIZE, :IMAGE)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':PRICE', $data["price"]);
            $stmt->bindParam(':SIZE' , $data["size"]);
            $stmt->bindParam(':IMAGE', $data["image"]);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    private function insertShirtName($data)
    {
        $sql = "INSERT INTO shirts_name (shirt, `value`, `language`) VALUES (:SHIRT, :VALUE, :LANGUAGE)";

        foreach ($data["name"] as $name) {
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':SHIRT', $data["shirt"]);
                $stmt->bindParam(':VALUE', $name["name"]);
                $stmt->bindParam(':LANGUAGE', $name["language"]);
                $stmt->execute();

                continue;
            } catch (\PDOException $e) {
                var_dump($e);
                return false;
            }
        }

        return true;
    }

    private function getLastId()
    {
        $sql = "SELECT * FROM shirts ORDER BY id DESC LIMIT 1";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Id', $id);
            $stmt->bindParam(':LANG', $lang);
            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_CLASS, ShirtModel::class);
            $result = $stmt->fetch(\PDO::FETCH_CLASS);

            return $result->id;
        } catch (\PDOException $e) {
            return null;
        }
    }
}