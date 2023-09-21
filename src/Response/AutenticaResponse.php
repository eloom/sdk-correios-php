<?php

namespace Eloom\SdkCorreios\Response;

class AutenticaResponse {

    public $token;

    public function __construct($response) {
        $this->token = $response->token;
    }
}
?>