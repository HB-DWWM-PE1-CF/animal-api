<?php

namespace App\Tests\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class AnimalApiTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/animals');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            "@context" => "/api/contexts/Animal",
            "@id" => "/api/animals",
            "@type" => "hydra:Collection",
        ]);
    }
}
