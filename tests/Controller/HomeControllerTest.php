<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testExist(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testContent(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSelectorTextContains('h1', 'Welcome');
        $this->assertSelectorExists('p');
    }

    public function testLinkDoc(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $client->clickLink('Go to API Doc (OpenAPI)');

        $this->assertSame('/api/docs', $client->getRequest()->getRequestUri());
    }

    public function testLinkGithub(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $client->clickLink('Github Repository');

        $this->assertSame('github.com', $client->getRequest()->getHost());
    }
}
