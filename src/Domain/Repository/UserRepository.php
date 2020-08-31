<?php

namespace App\Domain\Repository;

use PDO;

class UserRepository extends BaseRepository {
    /**
     * @param PDO
     */
    public function __construct(PDO $connection) {
       $this->connection = $connection;
    }

    /**
     * @param string
     * @return int
     */
    public function insertUser(string $username): int {
        $query = 'INSERT INTO users (username) VALUES (:username)';

        $statement = $this->connection->prepare($query);
        $statement -> bindParam(':username', $username);
        $statement -> execute();

        return (int) $this->connection->lastInsertId();
    }
}