<?php

namespace Eloom\Correios;

use Eloom\Correios\Endpoints\Autentica;
use Eloom\Correios\Endpoints\Prazo;
use Eloom\Correios\Endpoints\Preco;
use Eloom\Correios\Endpoints\Rastro;
use Eloom\Correios\Exceptions\InvalidJsonException;
use Eloom\Correios\Exceptions\CorreiosException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Client {
    /**
     * @var string
     */
    const BASE_URI = 'https://api.correios.com.br/';

    /**
     * @var string header used to identify application's requests
     */
    const USER_AGENT_HEADER = 'Magento-1.9.4.3';

    /**
     * @var \GuzzleHttp\Client
     */
    private $http;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $accessCode;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \Correios\Endpoints\Prazo
     */
    private $prazo;

    /**
     * @var \Correios\Endpoints\Preco
     */
    private $preco;

    /**
     * @var \Correios\Endpoints\Autentica
     */
    private $autentica;

    /**
     * @var \Correios\Endpoints\Rastro
     */
    private $rastro;

    /**
     * @param string $user
     * @param string $accessCode
     * @param array|null $extras
     */
    public function __construct($user, $accessCode, array $extras = null) {
        $this->user = $user;
        $this->accessCode = $accessCode;

        $options = ['base_uri' => self::BASE_URI];

        if (!is_null($extras)) {
            $options = array_merge($options, $extras);
        }

        $userAgent = isset($options['headers']['User-Agent']) ? $options['headers']['User-Agent'] : '';
        $options['headers']['User-Agent'] = $this->addUserAgentHeaders($userAgent);

        $this->http = new HttpClient($options);

        $this->autentica = new Autentica($this);
        $this->prazo = new Prazo($this);
        $this->preco = new Preco($this);
        $this->rastro = new Rastro($this);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @throws \Correios\Exceptions\CorreiosException
     * @return \ArrayObject
     *
     * @psalm-suppress InvalidNullableReturnType
     */
    public function request($method, $uri, $options = []) {
        $response = null;
        try {
            $response = $this->http->request($method, $uri, $options);
            
            return ResponseHandler::success($response->getBody());
        } catch (InvalidJsonException $exception) {
            throw $exception;
        } catch (RequestException $exception) {
            ResponseHandler::failure($exception);
        } catch (ClientException $exception) {
            ResponseHandler::failure($exception);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getAccessCode() {
        return $this->accessCode;
    }

    /**
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @param string $token
     * @return void
     */
    public function setToken(string $token) {
        return $this->token = $token;
    }

    /**
     * Build an user-agent string to be informed on requests
     *
     * @param string $customUserAgent
     *
     * @return string
     */
    private function buildUserAgent($customUserAgent = '') {
        return trim(sprintf(
            '%s | Magento 1.9.4.3 | Correios SDK %s | PHP Version %s',
            $customUserAgent,
            Correios::VERSION,
            phpversion()
        ));
    }

    /**
     * Append new keys (the default and pagarme) related to user-agent
     *
     * @param string $customUserAgent
     * @return string
     */
    private function addUserAgentHeaders($customUserAgent = '') {
        return $this->buildUserAgent($customUserAgent);
    }

    /**
     * @return \Correios\Endpoints\Autentica
     */
    public function autentica() {
        return $this->autentica;
    }

    /**
     * @return \Correios\Endpoints\Prazo
     */
    public function prazo() {
        return $this->prazo;
    }

    /**
     * @return \Correios\Endpoints\Preco
     */
    public function preco() {
        return $this->preco;
    }

    /**
     * @return \Correios\Endpoints\Rastro
     */
    public function rastro() {
        return $this->rastro;
    }
}
