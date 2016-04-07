<?php

namespace TradoLogic\Tests;

use TradoLogic\Exceptions\EmailAlreadyExistsException;
use TradoLogic\Requests\UserCreate;

class Users extends TestCase
{
    public function testEmailAlreadyExistsException()
    {
        $email = 'test.user.'.time().'@gmail.com';
        $password = md5(rand());

        $request = new UserCreate([
            'userPassword' => $password,
            'userFirstName' => $this->faker->firstName,
            'userLastName' => $this->faker->lastName,
            'phone' => $this->faker->randomNumber(8),
            'email' => $email,
        ]);

        /** @var \TradoLogic\Responses\UserCreate $response */
        $response = $this->apiClient->createUser($request);

        $this->assertTrue($response->isSuccess());

        try {
            $this->apiClient->createUser($request);
            $this->assertTrue(false, 'Abnormal registration behavior. Email already exists error not received.');
        } catch (EmailAlreadyExistsException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false, '\TradeSmarter\EmailAlreadyExists exception not raised.');
        }
    }
}
