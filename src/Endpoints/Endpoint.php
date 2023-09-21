<?php

namespace Eloom\SdkCorreios\Endpoints;

use Eloom\SdkCorreios\Client;

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
     * @var \SdkCorreios\Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }
}
