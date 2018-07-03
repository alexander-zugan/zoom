<?php

namespace Fessnik\Zoom\Http;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

class Request
{

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $apiKey;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $apiSecret;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \Illuminate\Config\Repository|mixed|null|string
     */
    protected $zoomUserId;

    /**
     * @var string
     */
    public $apiPoint = 'https://api.zoom.us/v2/';


    public function __construct()
    {
        $this->apiKey = config('zoom.api_key');

        $this->apiSecret = config('zoom.api_secret');

        $this->client = new Client();
    }

    /**
     * Headers
     *
     * @return array
     */
    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->generateJWT(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Generate J W T
     *
     * @return string
     */
    protected function generateJWT(): string
    {
        $token = [
            'iss' => $this->apiKey,
            'exp' => time() + 60,
        ];

        return JWT::encode($token, $this->apiSecret);
    }


    /**
     * Get
     *
     * @param $method
     * @param array $fields
     * @return array|mixed
     */
    protected function get($method, $fields = [])
    {
        try {
            $response = $this->client->request('GET', $this->apiPoint . $method, [
                'query' => $fields,
                'headers' => $this->headers(),
            ]);

            return $this->result($response);

        } catch (ClientException $e) {

            return (array)json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Post
     *
     * @param $method
     * @param $fields
     * @return array|mixed
     */
    protected function post($method, $fields)
    {
        $body = \json_encode($fields, JSON_PRETTY_PRINT);

        try {
            $response = $this->client->request('POST', $this->apiPoint . $method,
                ['body' => $body, 'headers' => $this->headers()]);

            return $this->result($response);

        } catch (ClientException $e) {

            return (array)json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Patch
     *
     * @param $method
     * @param $fields
     * @return array|mixed
     */
    protected function patch($method, $fields)
    {
        $body = \json_encode($fields, JSON_PRETTY_PRINT);

        try {
            $response = $this->client->request('PATCH', $this->apiPoint . $method,
                ['body' => $body, 'headers' => $this->headers()]);

            return $this->result($response);

        } catch (ClientException $e) {

            return (array)json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    protected function delete($method)
    {
        try {
            $response = $this->client->request('DELETE', $this->apiPoint . $method,
                [ 'headers' => $this->headers()]);

            return $this->result($response);

        } catch (ClientException $e) {

            return (array)json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Result
     *
     * @param Response $response
     * @return mixed
     */
    protected function result(Response $response)
    {
        $result = json_decode((string)$response->getBody(), true);

        $result['code'] = $response->getStatusCode();

        return $result;
    }
}