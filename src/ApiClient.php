<?php

namespace TradoLogic;

use GuzzleHttp;
use TradoLogic\Requests\UserCreate as UserCreateRequest;
use TradoLogic\Requests\UserGet as UserGetRequest;
use TradoLogic\Requests\UserLogin as UserLoginRequest;
use TradoLogic\Responses\Countries;
use TradoLogic\Responses\Languages;
use TradoLogic\Responses\UserCreate as UserCreateResponse;
use TradoLogic\Responses\UserGet as UserGetResponse;
use TradoLogic\Responses\UserLogin as UserLoginResponse;

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

        return ltrim($this->settings['url'], '/');
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
     * @throws \TradoLogic\Exception
     * @throws \Exception
     *
     * @return \TradoLogic\Payload
     */
    protected function request($method, $uri, $data = [])
    {
        $url = $this->getUrl().$uri;

        try {
            switch (strtoupper($method)) {
                case 'GET': {
                    $response = $this->getRequest($url, $data);
                    break;
                }
                case 'POST': {
                    $response = $this->postRequest($url, $data);
                    break;
                }
                default: {
                    throw new \Exception("Unknown request method [$method]");
                }
            }
        } catch (GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ServerException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
        }

        try {
            return new Payload($response);
        } catch (\UnexpectedValueException $e) {
            throw new \Exception('Invalid API response');
        }
    }

    protected function getRequest($url, $data)
    {
        $url .= ('?'.http_build_query($data));

        return $this->httpClient->get($url, [
            'headers' => [
                'User-Agent'   => 'TradoLogic API Client',
                'Content-Type' => 'application/json',
            ],
        ])->getBody()->getContents();
    }

    protected function postRequest($url, $data)
    {
        return $this->httpClient->post($url, [
            'body'    => json_encode($data),
            'headers' => [
                'User-Agent'   => 'TradoLogic API Client',
                'Content-Type' => 'application/json',
            ],
        ])->getBody()->getContents();
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
     * @throws \TradoLogic\Exception
     *
     * @return \TradoLogic\Responses\UserCreate
     */
    public function createUser(UserCreateRequest $request)
    {
        $data = [
            'affiliateUsername' => $this->getUsername(),
            'accountId'         => $this->getAccountId(),
            'userFirstName'     => $request->getUserFirstName(),
            'userLastName'      => $request->getUserLastName(),
            'userPassword'      => $request->getUserPassword(),
            'phone'             => $request->getPhone(),
            'email'             => $request->getEmail(),
            'dealId'            => $request->getDealId(),
            'affiliateId'       => $request->getAffiliateId(),
            'subAffiliateId'    => $request->getSubAffiliateId(),
        ];
        $data['checksum'] = $this->getChecksum($data);

        $payload = $this->request('POST', '/v1/affiliate/users', $data);

        return new UserCreateResponse($payload);
    }

    /**
     * @param \TradoLogic\Requests\UserGet $request
     *
     * @throws \TradoLogic\Exception
     *
     * @return \TradoLogic\Responses\UserGet
     */
    public function getUser(UserGetRequest $request)
    {
        $data = [
            'affiliateUsername' => $this->getUsername(),
            'accountId'         => $this->getAccountId(),
            'userId'            => $request->getUserId(),
        ];
        $data['checksum'] = $this->getChecksum($data);
        unset($data['userId']);

        $payload = $this->request('GET', '/v1/affiliate/users/'.$request->getUserId(), $data);

        return new UserGetResponse($payload);
    }

    /**
     * @param \TradoLogic\Requests\UserLogin $request
     *
     * @throws \TradoLogic\Exception
     *
     * @return \TradoLogic\Responses\UserLogin
     */
    public function loginUser(UserLoginRequest $request)
    {
        $data = [
            'affiliateUsername' => $this->getUsername(),
            'accountId'         => $this->getAccountId(),
            'email'             => $request->getEmail(),
            'password'          => $request->getPassword(),
            'userIpAddress'     => $request->getUserIpAddress(),
        ];
        $data['checksum'] = $this->getChecksum($data);

        $payload = $this->request('POST', '/v1/affiliate/users/login', $data);

        return new UserLoginResponse($payload);
    }
}
