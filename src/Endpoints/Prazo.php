<?php

namespace Eloom\Correios\Endpoints;

use Eloom\Correios\Routers;

use stdClass;

class Prazo extends Endpoint {

    private $products = [];

    private $cepOrigem;

    private $cepDestino;
    
    /**
     *
     */
    public function nacional() {
        $prazos = [];
        $dtEvento = date("d/m/Y");

        foreach($this->products as $index => $p) {

            $prazo = new stdClass();
            $prazo->coProduto = $p;
            $prazo->cepOrigem = $this->cepOrigem;
            $prazo->cepDestino = $this->cepDestino;
            $prazo->nuRequisicao = ($index +1);
            $prazo->dtEvento = $dtEvento;

            $prazos[] =  $prazo;
        }

        $body = new stdClass();
        $body->idLote = '1';
        $body->parametrosPrazo = array_values($prazos);

        $response = $this->client->request(self::POST,
            Routers::prazo()->nacional(),
            ['debug' => false,
            'headers' => ['Authorization' => 'Bearer ' . $this->client->getToken()],
            'json' => $body
            ]
        );
        
        return $response;
    }

    public function withProduct($product) {
        array_push($this->products, $product);

        return $this;
    }

    public function withCepOrigem($cepOrigem) {
        $this->cepOrigem = $cepOrigem;

        return $this;
    }

    public function withCepDestino($cepDestino) {
        $this->cepDestino = $cepDestino;

        return $this;
    }
}
?>