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
?>