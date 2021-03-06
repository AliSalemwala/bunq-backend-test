<?php

namespace App\Domain\Repository;

use PDO;

class BaseRepository {
    /**
     * @var PDO
     */
    private $connection;

    /**
     * @param PDO
     */
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }
}