<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @param string $url
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful(string $url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @return \Generator
     */
    public function urlProvider()
    {
        yield ['/students'];
        yield ['/students/new'];
    }
}
