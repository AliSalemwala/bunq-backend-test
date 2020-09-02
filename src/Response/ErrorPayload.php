<?php

namespace App\Response;

use JsonSerializable;

class ErrorPayload implements JsonSerializable {
    /**
     * @var string
     */
    private $errorType;

    /**
     * @var string
     */
    private $description;

    /**
     * @param string
     * @param string|null
     */
    public function __construct(string $errorType, string $description = null) {
        $this->errorType = $errorType;
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array {
        $error = [
            'errorType' => $this->errorType,
        ];

        if ($this->description !== null) {
            $error['description'] = $this->description;
        }

        return $error;
    }
}