<?php

namespace App\Domain\Message\Repository;

use Exception;
use App\Domain\Message\Data\MessageData;
use PDO;

class MessageRepository {
    private $pdo;
    public function __construct(PDO $pdo) {
       $this->pdo = $pdo;
    }

    protected function validationCheck (array $data, string $param): string {
        if (empty($data[$param])) {
            throw new Exception("Incorrect input `{$param}` given", 500);
        }
        return $data[$param];
    }

//Check if the user is already present
    protected function ifExist (array $data, string $param): string {     
        $userName = $data['userName'];
        $query = 'SELECT userName
                  FROM usersTable
                  WHERE userName = :userName';;
        if(empty($query)){
            throw new Exception("UserName `{$param}` doesnot exist", 500);
        }
        return $data[$param];
    }

    public function insertMessage(array $data): int {
        $messageSender = $this->validationCheck ($data, 'messageSender');
        $messageReciever = $this->validationCheck ($data, 'messageReciever');
        $messageContent = $this->validationCheck ($data, 'messageContent');

        //check if valid userName is provided
        $messageSender = $this->ifExist ($data, 'messageSender');
        $messageReciever = $this->ifExist ($data, 'messageReciever');

        $query = 'INSERT INTO messagesTable (messageSender, messageReciever, messageContent) VALUES (:messageSender, :messageReciever, :messageContent)';

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':messageSender', $messageSender);
        $statement->bindParam(':messageReciever', $messageReciever);
        $statement->bindParam(':messageContent', $messageContent);
        $statement->execute();

        return $this->pdo->lastInsertId();
    }

    public function selectMessagesByRecipient (string $messageReciever): array {
        $messageArray = array();
        $query = 'SELECT *
				  FROM messagesTable
				  WHERE messageReciever = :messageReciever';

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':messageReciever', $messageReciever);
        $statement->execute();
        
        $messagesFromDB = $statement->fetchAll();
        
        foreach($messagesFromDB as $message) {
            array_push($messageArray, new MessageData ($message['messageID'], $message['messageSender'], $message['messageReciever'], $message['messageContent']));
        }
        return $messageArray;
    }
}