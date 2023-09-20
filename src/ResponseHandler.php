<?php

namespace Correios;

use GuzzleHttp\Exception\ClientException;
use Correios\Exceptions\CorreiosException;
use Correios\Exceptions\InvalidJsonException;
use Correios\Exceptions\UnauthorizedException;

class ResponseHandler {

    /**
     * @param string $payload
     *
     * @throws \Correios\Exceptions\InvalidJsonException
     * @return \ArrayObject
     */
    public static function success($payload) {
        return self::toJson($payload);
    }

    /**
     * @param ClientException $originalException
     *
     * @throws PagarMeException
     * @return void
     */
    public static function failure(\Exception $originalException) {
        throw self::parseException($originalException);
    }

    /**
     * @param ClientException $guzzleException
     *
     * @return CorreiosException|ClientException
     */
    private static function parseException(ClientException $guzzleException) {
        $response = $guzzleException->getResponse();

        if (is_null($response)) {
            return $guzzleException;
        }

        if($response->getStatusCode() == 400 || $response->getStatusCode() == 401) {
            return new UnauthorizedException('401 Unauthorized', date("d/m/Y"), '/v1/autentica/cartaopostagem');
        }

        //echo 'Status Code ' . $response->getStatusCode() . "\n";

        $body = $response->getBody()->getContents();

        $jsonError = null;
        
        try {
            $jsonError = self::toJson($body);
        } catch (InvalidJsonException $invalidJson) {
            return $guzzleException;
        }

        return new CorreiosException($jsonError->msgs, $jsonError->date, $jsonError->path);
    }

    /**
     * @param string $json
     * @return \ArrayObject
     */
    private static function toJson($json) {
        $result = json_decode($json);

        if (json_last_error() != \JSON_ERROR_NONE) {
            throw new InvalidJsonException(json_last_error_msg());
        }

        return $result;
    }
}
?>