<?php

define('SDK_ROOT', getcwd());
require_once SDK_ROOT . '/vendor/autoload.php';

use Eloom\SdkCorreios\Client;

$user = '';
$codigoAcesso = '';
$cartaoPostagem = '';

$client = new Client($user, $codigoAcesso);
try {
    var_export($client->autentica()->cartaoPostagem($cartaoPostagem));
} catch (\Throwable $e) {
    echo $e->getMessage();
}

$client->prazo()->withProduct('04162')->withProduct('04669')->withCepOrigem('88330725')->withCepDestino('92010130')->nacional();

$client->preco()->withProduct('04162')
->withProduct('04669')
->withCepOrigem('88330725')
->withCepDestino('92010130')
->withPsObjeto('300')
->withTpObjeto('2')
->withComprimento('20')
->withLargura('20')
->withAltura('20')
->withDiametro('20')
->withDtEvento(date("d/m/Y"))
->nacional();

$client->rastro()->withCodigoObjeto('NL832806015BR')->withResultado(Rastro::EVENTOS_TODOS)->objeto();
?>