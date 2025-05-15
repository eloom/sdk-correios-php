<?php
declare(strict_types=1);

namespace Eloom\SdkCorreios\Endpoints;

use Eloom\SdkCorreios\Response\AutenticaResponse;
use Eloom\SdkCorreios\Routers;

class Autentica extends Endpoint {

  /**
   * @param string $cartaoPostagem
   *
   * @return AutenticaResponse
   */
  public function cartaoPostagem(string $cartaoPostagem) {
    $response = $this->client->request(self::POST,
      Routers::autentica()->cartaoPostagem(),
      ['auth' => [$this->client->getUser(), $this->client->getAccessCode()],
        'json' => ['numero' => $cartaoPostagem]]
    );

    $this->client->setToken($response->token);

    return $this;
    //return new AutenticaResponse($response);
  }
}
