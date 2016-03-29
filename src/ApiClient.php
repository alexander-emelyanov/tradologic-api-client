<?php

namespace TradoLogic;

use GuzzleHttp;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use TradoLogic\Requests\UserCreate as UserCreateRequest;
use TradoLogic\Requests\UserGet as UserGetRequest;
use TradoLogic\Requests\UserLogin as UserLoginRequest;
use TradoLogic\Responses\Countries;
use TradoLogic\Responses\Deposits as DepositsResponse;
use TradoLogic\Responses\Languages;
use TradoLogic\Responses\UserCreate as UserCreateResponse;
use TradoLogic\Responses\UserGet as UserGetResponse;
use TradoLogic\Responses\UserLogin as UserLoginResponse;

class ApiClient implements LoggerAwareInterface
{
    protected $settings = [];

    /**
     * @var \GuzzleHttp\ClientInterface A Guzzle HTTP client.
     */
    protected $httpClient;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct($settings = [])
    {
        $this->settings = $settings;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function getHttpClient()
    {
        if (!is_null($this->httpClient)) {
            return $this->httpClient;
        }

        $stack = GuzzleHttp\HandlerStack::create();

        if ($this->logger instanceof LoggerInterface) {
            $stack->push(GuzzleHttp\Middleware::log(
                $this->logger,
                new GuzzleHttp\MessageFormatter(GuzzleHttp\MessageFormatter::DEBUG)
            ));
        }

        $this->httpClient = new GuzzleHttp\Client([
            'base_uri' => $this->getUrl(),
            'handler'  => $stack,
        ]);

        return $this->httpClient;
    }

    protected function getUrl()
    {
        if (!isset($this->settings['url'])) {
            throw new \Exception('URL not configured');
        }

        return ltrim($this->settings['url'], '/');
    }

    protected function getUsername()
    {
        if (!isset($this->settings['username'])) {
            throw new \Exception('Affiliate username not configured');
        }

        return $this->settings['username'];
    }

    protected function getPassword()
    {
        if (!isset($this->settings['password'])) {
            throw new \Exception('Affiliate password not configured');
        }

        return $this->settings['password'];
    }

    protected function getAccountId()
    {
        if (!isset($this->settings['accountId'])) {
            throw new \Exception('Account ID of brand not configured');
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
        try {
            switch (strtoupper($method)) {
                case 'GET': {
                    $response = $this->getRequest($uri, $data);
                    break;
                }
                case 'POST': {
                    $response = $this->postRequest($uri, $data);
                    break;
                }
                default: {
                    throw new \Exception("Unknown request method [$method]");
                }
            }
        } catch (GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse()->getBody();
        } catch (GuzzleHttp\Exception\ServerException $exception) {
            $response = $exception->getResponse()->getBody();
        }

        /* @var \Psr\Http\Message\StreamInterface $response */

        try {
            return new Payload((string) $response);
        } catch (\UnexpectedValueException $e) {
            throw new \Exception('Invalid API response');
        }
    }

    protected function getRequest($url, $data)
    {
        $url .= ('?'.http_build_query($data));

        return $this->getHttpClient()
            ->get($url, [
            'headers' => [
                'User-Agent'   => 'TradoLogic API Client',
                'Content-Type' => 'application/json',
            ],
        ])->getBody();
    }

    protected function postRequest($url, $data)
    {
        return $this->getHttpClient()
            ->post($url, [
            'body'    => json_encode($data),
            'headers' => [
                'User-Agent'   => 'TradoLogic API Client',
                'Content-Type' => 'application/json',
            ],
        ])->getBody();
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
            'subAffiliateId'    => $request->getSubAffiliateId(),
            'countryCode'       => $request->getCountryCode(),
            'userIpAddress'     => $request->getUserIpAddress(),
            'languageCode'      => $request->getLanguageCode(),
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

    /**
     * Retrieves the deposits of the affiliate's users by a selected timestamp.
     *
     * @param int $fromTimestamp The date after which the deposit was confirmed.
     * @param int $toTimestamp   The date before which the deposit was confirmed.
     *
     * @throws \Exception
     *
     * @return \TradoLogic\Entities\Deposit[]
     */
    public function getDeposits($fromTimestamp = 0, $toTimestamp = null)
    {
        if ($toTimestamp === null) {
            $toTimestamp = time();
        }
        $data = [
            'affiliateUsername' => $this->getUsername(),
            'accountId'         => $this->getAccountId(),
            'confirmedAfter'    => max(1, intval($fromTimestamp)),
            'confirmedBefore'   => max(1, intval($toTimestamp)),
        ];
        $data['checksum'] = $this->getChecksum($data);

        $payload = $this->request('GET', '/v1/affiliate/deposits', $data);
        $response = new DepositsResponse($payload);

        return $response->getData();
    }
}
