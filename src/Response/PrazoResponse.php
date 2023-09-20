<?php

namespace Correios\Response;

use stdClass;

class PrazoResponse {

    public $coProduto;

    public $nuRequisicao;

    public $prazoEntrega;

    public $dataMaxima;

    public $entregaDomiciliar;

    public $entregaSabado;

    public $msgPrazo;

    public function __construct(stdClass $prazo) {
        $this->coProduto = $prazo->coProduto;
        $this->nuRequisicao = $prazo->nuRequisicao;
        $this->prazoEntrega = $prazo->prazoEntrega;
        $this->dataMaxima = $prazo->dataMaxima;
        $this->entregaDomiciliar = $prazo->entregaDomiciliar;
        $this->entregaSabado = $prazo->entregaSabado;
        $this->msgPrazo = $prazo->msgPrazo;
    }
}
?>