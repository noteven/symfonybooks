<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    private static string $BASE_URI = '/api/books';
    private static string $VALID_ID = '1';
    private static string $INVALID_ID = '34';

    public function testGetBooks(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::$BASE_URI);

    }

    public function testGetBookValidId(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::$BASE_URI . self::$VALID_ID);

    }

    public function testGetBookInvalidId(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::$BASE_URI . self::$INVALID_ID);

    }

    public function testGetBooksFilterByPublicationYear(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::$BASE_URI);

        $this->assertResponseIsSuccessful();
    }

    public function testGetBooksFilterByAuthorsCount(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::$BASE_URI . '?authors[gte]=12');

        $this->assertResponseIsSuccessful();
    }

    public function testPostNewBookValidData(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', self::$BASE_URI);

        $this->assertResponseIsSuccessful();
    }

    public function testPostNewBookInvalidData(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', self::$BASE_URI);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteBookValidId(): void
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', self::$BASE_URI . self::$VALID_ID);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteBookInvalidId(): void
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', self::$BASE_URI . self::$INVALID_ID);

        $this->assertResponseIsSuccessful();
    }

    public function testPutBookValidData(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::$BASE_URI . self::$VALID_ID);

        $this->assertResponseIsSuccessful();
    }

    public function testPutBookInvalidId(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::$BASE_URI . self::$INVALID_ID);

        $this->assertResponseIsSuccessful();
    }

    public function testPutBookInvalidData(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::$BASE_URI . self::$VALID_ID);

        $this->assertResponseIsSuccessful();
    }
}
