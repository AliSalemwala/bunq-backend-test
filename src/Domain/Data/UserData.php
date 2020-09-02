<?php

namespace App\Domain\Data;

use JsonSerializable;

class UserData implements JsonSerializable {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @param int
     * @param string
     */
    public function __construct (int $id, string $username) {
        $this->id = $id;
        $this->username = strtolower($username);
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'username' => $this->username
        ];
    }
}