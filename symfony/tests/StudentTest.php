<?php
/*
 * This file is part of TechnicalTestSymfony4.
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 * @link https://github.com/RealAestan/TechnicalTestSymfony4
 */
declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StudentTest extends WebTestCase
{
    public function testPostStudent(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/students/new');
        $form = $crawler->filter('form')->form([
            'student[firstName]' => 'John',
            'student[lastName]' => 'Snow',
            'student[birthDate][day]' => '6',
            'student[birthDate][month]' => '6',
            'student[birthDate][year]' => '1966',
        ]);
        $this->assertTrue(
            \strpos(
                $client->submit($form)->html(),
                'Redirecting to /students'
            ) !== false
        );
    }
}
