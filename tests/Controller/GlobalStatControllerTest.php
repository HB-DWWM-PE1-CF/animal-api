<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GlobalStatControllerTest extends WebTestCase
{
    public function testNoLogged(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/global-stat');

        $this->assertResponseStatusCodeSame(401);
    }

    public function testLogged(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getUser());
        $crawler = $client->request('GET', '/api/global-stat');

        $this->assertResponseIsSuccessful();
    }

    public function testExistData(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getUser());
        $crawler = $client->request('GET', '/api/global-stat');
        $response = $client->getResponse();

        // Check if is JSON data.
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        // Convert JSON string to PHP array.
        $data = json_decode($response->getContent(), true);

        // Check info exist.
        $this->assertArrayHasKey('total_animals', $data);
        $this->assertArrayHasKey('total_animals_without_owner', $data);
    }

    private function getUser(): User
    {
        $container = static::getContainer();
        /** @var UserRepository $repo */
        $repo = $container->get(UserRepository::class);

//        return $repo->findOneBy(['email' => 'foo@bar.fr']);
        return $repo->findOneByEmail('foo@bar.fr');
    }
}
