<?php

namespace Correios\Endpoints;

use Correios\Routers;

class Rastro extends Endpoint {

    const EVENTOS_TODOS = 'T';

    const EVENTOS_PRIMEIRO = 'P';

    const EVENTOS_ULTIMO = 'U';

    private $codigoObjeto;

    private $resultado;

    /**
     *
     */
    public function objeto() {
        $response = $this->client->request(self::GET,
            Routers::rastro()->objeto($this->codigoObjeto),
            ['debug' => false,
            'headers' => ['Authorization' => 'Bearer ' . $this->client->getToken()],
            'query' => [
                'resultado' => $this->resultado
            ]]
        );
        
        return $response;
    }

    public function withCodigoObjeto($codigoObjeto) {
        $this->codigoObjeto = $codigoObjeto;

        return $this;
    }

    public function withResultado($resultado) {
        $this->resultado = $resultado;

        return $this;
    }
}
?>