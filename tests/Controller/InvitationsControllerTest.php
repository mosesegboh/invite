<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Helpers\Constants;

class InvitationsControllerTest extends WebTestCase
{   
    /**
     * Testing the search function in InvitationsController
     *
     * @return void
     */
    public function testSearch(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail(Constants::TEST_USER_EMAIL);

        $client->loginUser($testUser);

        $crawler = $client->request('POST', '/search');

        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }

    /**
     * Testing the submitInvite function in InvitationsController
     *
     * @return void
     */
    public function testSubmitInvite(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail(Constants::TEST_USER_EMAIL);

        $client->loginUser($testUser);

        $client->xmlHttpRequest('POST', '/invite', ['subject'=>'tester', 'message' => 'tester', 'send_to' => 'test4@tester.com', 'acceptance' => 0]);

        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }
}
