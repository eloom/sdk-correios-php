<?php

namespace Eloom\Correios\Endpoints;

use Eloom\Correios\Routers;
use Eloom\Correios\Response\AutenticaResponse;

class Autentica extends Endpoint {
    
    /**
     * @param string $cartaoPostagem
     *
     * @return Correios\Response\AutenticaResponse
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
?>