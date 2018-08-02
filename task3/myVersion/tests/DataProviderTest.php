<?php
namespace Task3\tests\tests;

use Katzgrau\KLogger\Logger;
use PHPUnit\Framework\TestCase;
use Task3\Integration\DataProvider;
use Task3\Integration\DataProviderCacheDecorator;
use Task3\Integration\DataProviderLoggerDecorator;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class DataProviderTest extends TestCase
{
    public function testDataProvider()
    {
        $provider = new DataProvider('localhost', 'user', 'secret');

        $this->assertEquals([], $provider->get([]));
    }

    public function testDataProviderCacheDecorator()
    {
        $provider = new DataProvider('localhost', 'user', 'secret');
        $provider = new DataProviderCacheDecorator($provider, new FilesystemAdapter());

        $this->assertEquals([], $provider->get([]));
    }

    public function testDataProviderLoggerDecorator()
    {
        $provider = new DataProvider('localhost', 'user', 'secret');
        $provider = new DataProviderLoggerDecorator($provider, new Logger(__DIR__));

        $this->assertEquals([], $provider->get([]));
    }

    public function testDataProviderAll()
    {
        $provider = new DataProvider('localhost', 'user', 'secret');
        $provider = new DataProviderCacheDecorator($provider, new FilesystemAdapter());
        $provider = new DataProviderLoggerDecorator($provider, new Logger(__DIR__));

        $this->assertEquals([], $provider->get([]));
    }
}
