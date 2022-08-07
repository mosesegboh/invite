<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Helpers\Constants;

class HomeControllerTest extends WebTestCase
{   
    /**
     * Testing the index function in Homecontroller
     *
     * @return void
     */
    public function testIndex(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail(Constants::TEST_USER_EMAIL);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/home');

        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
    }

    /**
     * Testing the getInvitations function in Homecontroller
     *
     * @return void
     */
    public function testGetInvitations(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail(Constants::TEST_USER_EMAIL);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/get-invitations');

        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }

    /**
     * Testing the accept function in Homecontroller
     *
     * @return void
     */
    public function testAccept(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail(Constants::TEST_USER_EMAIL);

        $client->loginUser($testUser);

        $crawler = $client->request('POST', '/accept', ['id' => 3]);

        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }

    /**
     * Testing the decline function in Homecontroller
     *
     * @return void
     */
    public function testDecline(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail(Constants::TEST_USER_EMAIL);

        $client->loginUser($testUser);

        $crawler = $client->request('POST', '/decline', ['id' => 3]);

        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
    }
}
