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

    private function getUser(): User
    {
        $container = static::getContainer();
        /** @var UserRepository $repo */
        $repo = $container->get(UserRepository::class);

//        return $repo->findOneBy(['email' => 'foo@bar.fr']);
        return $repo->findOneByEmail('foo@bar.fr');
    }
}
