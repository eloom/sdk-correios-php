<?php
declare(strict_types=1);

namespace Eloom\SdkCorreios\Response;

class AutenticaResponse {

  public $token;

  public function __construct($response) {
    $this->token = $response->token;
  }
}
