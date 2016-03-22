<?php

namespace TradoLogic;

use GuzzleHttp;
use TradoLogic\Requests\UserCreate as UserCreateRequest;
use TradoLogic\Responses\UserCreate as UserCreateResponse;
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
        if (!isset($this->settings['url'])) {
            throw new Exception('URL not configured');
        }

        return $this->settings['url'];
    }

    protected function getUsername()
    {
        if (!isset($this->settings['username'])) {
            throw new Exception('Affiliate username not configured');
        }

        return $this->settings['username'];
    }

    protected function getPassword()
    {
        if (!isset($this->settings['password'])) {
            throw new Exception('Affiliate password not configured');
        }

        return $this->settings['password'];
    }

    protected function getAccountId()
    {
        if (!isset($this->settings['accountId'])) {
            throw new Exception('Account ID of brand not configured');
        }

        return $this->settings['accountId'];
    }

    protected function getChecksum($data)
    {
        ksort($data);
        $data = array_values($data);
        $stringForHash = implode($data).$this->getPassword();

        return hash('sha256', $stringForHash);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $data
     *
     * @throws Exception
     *
     * @return Payload
     */
    protected function request($method, $uri, $data = [])
    {
        $url = $this->getUrl().$uri;

        try {
            $response = $this->httpClient->request($method, $url, [
                'body' => json_encode($data),
                // 'debug' => true,
                'headers' => [
                    'User-Agent'   => 'TradoLogic API Client',
                    'Content-Type' => 'application/json',
                ],
            ])->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ServerException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
        }

        return new Payload($response);
    }

    /**
     * @return \TradoLogic\Entities\Country[]
     */
    public function countries()
    {
        $payload = $this->request('GET', '/v1/nomenclature/countries');
        $response = new Countries($payload);

        return $response->getData();
    }

    /**
     * @return \TradoLogic\Entities\Language[]
     */
    public function languages()
    {
        $payload = $this->request('GET', '/v1/nomenclature/languages');
        $response = new Languages($payload);

        return $response->getData();
    }

    /**
     * @param \TradoLogic\Requests\UserCreate $request
     *
     * @return \TradoLogic\Responses\UserCreate
     *
     * @throws Exception
     */
    public function createUser(UserCreateRequest $request)
    {
        $data = [
            'userFirstName'     => $request->getUserFirstName(),
            'userLastName'      => $request->getUserLastName(),
            'userPassword'      => $request->getUserPassword(),
            'phone'             => $request->getPhone(),
            'email'             => $request->getEmail(),
            'accountId'         => $this->getAccountId(),
            'affiliateUsername' => $this->getUsername(),
        ];
        $data['checksum'] = $this->getChecksum($data);

        $payload = $this->request('POST', "/v1/affiliate/users", $data);
        return new UserCreateResponse($payload);
    }
}
