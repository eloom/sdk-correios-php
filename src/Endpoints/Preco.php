<?php
declare(strict_types=1);

namespace Eloom\SdkCorreios\Endpoints;

use Eloom\SdkCorreios\Routers;
use stdClass;

class Preco extends Endpoint {

  private $products = [];

  private $cepOrigem;

  private $cepDestino;

  private $psObjeto;

  private $tpObjeto;

  private $comprimento;

  private $largura;

  private $altura;

  private $diametro;

  private $vlDeclarado;

  private $dtEvento;

  private $servicosAdicionais = [];

  /**
   *
   */
  public function nacional() {
    $precos = [];

    foreach ($this->products as $index => $p) {

      $preco = new stdClass();
      $preco->coProduto = $p;
      $preco->cepOrigem = $this->cepOrigem;
      $preco->cepDestino = $this->cepDestino;
      $preco->psObjeto = $this->psObjeto;
      $preco->tpObjeto = $this->tpObjeto;
      $preco->comprimento = $this->comprimento;
      $preco->largura = $this->largura;
      $preco->altura = $this->altura;
      $preco->diametro = $this->diametro;
      $preco->vlDeclarado = $this->vlDeclarado;
      $preco->dtEvento = $this->dtEvento;
      //$preco->servicosAdicionais = $this->servicosAdicionais;
      $preco->nuRequisicao = ($index + 1);

      $precos[] = $preco;
    }

    $body = new stdClass();
    $body->idLote = '1';
    $body->parametrosProduto = array_values($precos);

    $response = $this->client->request(self::POST,
      Routers::preco()->nacional(),
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

  public function withPsObjeto($psObjeto) {
    $this->psObjeto = $psObjeto;

    return $this;
  }

  public function withTpObjeto($tpObjeto) {
    $this->tpObjeto = $tpObjeto;

    return $this;
  }

  public function withComprimento($comprimento) {
    $this->comprimento = $comprimento;

    return $this;
  }

  public function withLargura($largura) {
    $this->largura = $largura;

    return $this;
  }

  public function withAltura($altura) {
    $this->altura = $altura;

    return $this;
  }

  public function withVlDeclarado($vlDeclarado) {
    $this->vlDeclarado = $vlDeclarado;

    return $this;
  }

  public function withDtEvento($dtEvento) {
    $this->dtEvento = $dtEvento;

    return $this;
  }

  public function withCepDestino($cepDestino) {
    $this->cepDestino = $cepDestino;

    return $this;
  }

  public function withServicosAdicionais($servicosAdicionais) {
    $this->servicosAdicionais = $servicosAdicionais;

    return $this;
  }

  public function withDiametro($diametro) {
    $this->diametro = $diametro;

    return $this;
  }
}
