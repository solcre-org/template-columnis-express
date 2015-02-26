<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiService
 *
 * @author matias
 */

namespace Columnis\Service;

use GuzzleHttp\Client as GuzzleClient;
use Columnis\Model\ApiResponse;
use Columnis\Exception\Api\ApiRequestException;

class ApiService {

    /**
     * Guzzle Client
     * @var \GuzzleHttp\Client $httpClient
     */
    protected $httpClient;

    /*
     * Columnis Api Client Number
     * @var string $clientNumber
     */
    protected $clientNumber;

    /**
     * Returns the Guzzle Client
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient() {
        return $this->httpClient;
    }

    /**
     * Sets the Guzzle Client
     * @param \GuzzleHttp\Client $httpClient
     */
    public function setHttpClient(GuzzleClient $httpClient) {
        $this->httpClient = $httpClient;
    }

    /**
     * Returns the Client Number of Columnis Api
     * @return string
     */
    public function getClientNumber() {
        return $this->clientNumber;
    }

    /**
     * Sets the Client Number of Columnis Api
     * @param string $clientNumber
     */
    public function setClientNumber($clientNumber) {
        $this->clientNumber = $clientNumber;
    }

    public function __construct(GuzzleClient $httpClient, $clientNumber) {
        $this->setHttpClient($httpClient);
        $this->setClientNumber($clientNumber);
    }

    /**
     * Performs a request to Columnis api
     *
     * @param string $uri
     * @return ApiResponse
     * @trows ApiRequestException
     */
    public function request($uri, $method = 'GET') {
        $options = array(
            'headers' => array(
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
        ));
        try {
            $httpClient = $this->getHttpClient();
            $request = $httpClient->createRequest($method, $uri, $options);
            $response = $httpClient->send($request);
            $apiResponse = new ApiResponse($response);
        } catch(\GuzzleHttp\Exception\RequestException $e) {
            
            throw new ApiRequestException('Api Request failed: '.$e->getMessage(), 0, $e);
        }
        return $apiResponse;
    }

    /**
     * Gets the Uri for the desire enpoint
     * @param string $endpoint
     * @return string
     */
    public function getUri($endpoint) {
        return $this->getClientNumber().'/columnis'.$endpoint;
    }
}
