<?php

namespace App\Response;

use JsonSerializable;

class ErrorPayload implements JsonSerializable {

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $description;

    /**
     * @param string
     * @param string|null
     */
    public function __construct(string $type, string $description = null) {
        $this->type = $type;
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function jsonSerialize() {
        $error = [
            'type' => $this->type,
        ];

        if ($this->description !== null) {
            $error['description'] = $this->description;
        }

        return $error;
    }
}