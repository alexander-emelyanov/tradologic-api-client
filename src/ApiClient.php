<?php

namespace TradoLogic;

use GuzzleHttp;
use TradoLogic\Requests\UserCreate;
use TradoLogic\Responses\Countries;
use TradoLogic\Responses\Languages;

class ApiClient
{
    protected $settings = [];

    /**
     * @var \GuzzleHttp\ClientInterface A Guzzle HTTP client.
     */
    protected $httpClient;

    public function __construct($settings = [], GuzzleHttp\ClientInterface $httpClient = null)
    {
        $this->settings = $settings;
        $this->httpClient = $httpClient ?: new GuzzleHttp\Client();
    }

    protected function getUrl()
    {
        if (!isset($this->settings['url'])){
            throw new Exception('URL not configured');
        }

        return $this->settings['url'];
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $data
     * @return Payload
     * @throws Exception
     */
    protected function request($method, $uri, $data = [])
    {
        $url = $this->getUrl() . $uri;

        try {
            $response = $this->httpClient->request($method, $url, [
                'body' => json_encode($data),
                // 'debug' => true,
                'headers' => [
                    'User-Agent' => 'TradoLogic API Client',
                ]
            ])->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ClientException $exception){
            $response = $exception->getResponse()->getBody()->getContents();
        }
        catch (GuzzleHttp\Exception\ServerException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
        }
        return new Payload($response);
    }

    /**
     * @return \TradoLogic\Entities\Country[]
     */
    public function countries()
    {
        $payload = $this->request('GET', "/v1/nomenclature/countries");
        $response = new Countries($payload);
        return $response->getData();
    }

    /**
     * @return \TradoLogic\Entities\Language[]
     */
    public function languages()
    {
        $payload = $this->request('GET', "/v1/nomenclature/languages");
        $response = new Languages($payload);
        return $response->getData();
    }

    public function registerUser(UserCreate $request)
    {
        $payload = $this->request('POST', "/v1/users", []);
        return new Response($payload);
    }
}