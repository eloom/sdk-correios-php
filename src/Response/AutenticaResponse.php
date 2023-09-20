<?php

namespace Eloom\Correios\Response;

class AutenticaResponse {

    public $token;

    public function __construct($response) {
        $this->token = $response->token;
    }
}
?>