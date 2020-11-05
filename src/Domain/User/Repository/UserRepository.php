<?php

namespace App\Domain\User\Repository;
use Exception;
use PDO;

class UserRepository {

    private $pdo;
    public function __construct(PDO $pdo) {
       $this->pdo = $pdo;
    }

    protected function checkParam (array $data, string $param): string {
        if (empty($data[$param])) {
            throw new Exception(" Incorrect input `{$param}` given", 500);
        }

        //Check if the user is already present
        $userName = $data[$param];
        $query = 'SELECT *
                  FROM usersTable
                  WHERE userName = :userName';;
        if(!$query){
            throw new Exception("UserName `{$param}` already exist", 500);
        }
        
        return $data[$param];
    }

    public function insertUser(array $data): int {
        $userName = $this->checkParam ($data, 'userName');

        $query = 'INSERT INTO usersTable (userName) VALUES (:userName)';

        $statement = $this->pdo->prepare($query);
        $statement -> bindParam(':userName', $userName);
        $statement -> execute();

        return $this->pdo->lastInsertId();
    }
}