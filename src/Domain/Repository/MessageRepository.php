<?php

namespace App\Domain\Repository;

use PDO;

class MessageRepository extends BaseRepository {

    /**
     * @param string
     * @param string
     * @param string
     * @return int
     */
    public function insertMessage(string $sender, string $recipient, string $body): int {
        $query = 'INSERT INTO messages (sender, recipient, body) VALUES (:sender, :recipient, :body)';

        $statement = $this->connection->prepare($query);
        $statement->bindParam(':sender', $sender);
        $statement->bindParam(':recipient', $recipient);
        $statement->bindParam(':body', $body);
        $statement->execute();

        return (int) $this->connection->lastInsertId();
    }

    /**
     * @param string
     * @return array
     */
    public function selectMessagesByRecipient (string $recipient) {
        $query = 'SELECT sender, recipient, body,
				  FROM messages
				  WHERE recipient = :recipient
				  ORDER BY m.time_stamp';


        $statement = $this->connection->prepare($query);
        $statement->bindParam(':recipient', $recipient);
        $statement->execute();
        
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        return $rows;


    }
}