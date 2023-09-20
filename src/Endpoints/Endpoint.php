<?php

namespace Correios\Endpoints;

use Correios\Client;

abstract class Endpoint {
    /**
     * @var string
     */
    const POST = 'POST';
    /**
     * @var string
     */
    const GET = 'GET';
    /**
     * @var string
     */
    const PUT = 'PUT';
    /**
     * @var string
     */
    const DELETE = 'DELETE';

    /**
     * @var \Correios\Client
     */
    protected $client;

    /**
     * @param \Correios\Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }
}
