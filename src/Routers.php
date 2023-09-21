<?php

namespace Eloom\SdkCorreios;

class Routers {

    public static function autentica() {
        $anonymous = new Anonymous();
        $anonymous->cartaoPostagem = static function() {
            return "token/v1/autentica/cartaopostagem";
        };

        return $anonymous;
    }

    public static function prazo() {
        $anonymous = new Anonymous();
        $anonymous->nacional = static function() {
            return "prazo/v1/nacional";
        };

        return $anonymous;
    }

    public static function preco() {
        $anonymous = new Anonymous();
        $anonymous->nacional = static function() {
            return "preco/v1/nacional";
        };

        return $anonymous;
    }

    public static function rastro() {
        $anonymous = new Anonymous();
        $anonymous->objeto = static function(string $codigoObjeto) {
            return "srorastro/v1/objetos/$codigoObjeto";
        };

        return $anonymous;
    }
}
?>