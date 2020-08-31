<?php

namespace App\Response;

use JsonSerializable;

class Payload implements JsonSerializable {

    /**
     * @var array|object|null
     */
    private $data;

    /**
     * @param array|object|null     $data
     */
    public function __construct (
        $data = null
    ) {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function jsonSerialize() {
        $payload = [];

        if ($this->data !== null) {
            $payload['data'] = $this->data;
        }

        return $payload;
    }
}