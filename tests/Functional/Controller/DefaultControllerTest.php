<?php
declare(strict_types=1);
/**
 * /tests/Functional/Controller/DefaultControllerTest.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Tests\Functional\Controller;

use App\Resource\LogRequestResource;
use App\Utils\Tests\WebTestCase;

/**
 * Class DefaultControllerTest
 *
 * @package App\Tests\Functional\Controller
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
class DefaultControllerTest extends WebTestCase
{
    public function testThatDefaultRouteReturns200(): void
    {
        $client = $this->getClient();
        $client->request('GET', '/');

        $response = $client->getResponse();

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(200, $response->getStatusCode());
    }

    public function testThatHealthzRouteReturns200(): void
    {
        $client = $this->getClient();
        $client->request('GET', '/healthz');

        $response = $client->getResponse();

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(200, $response->getStatusCode());
    }

    public function testThatHealthzRouteDoesNotMakeRequestLog(): void
    {
        static::bootKernel();

        /** @var LogRequestResource $resource */
        $resource = static::$kernel->getContainer()->get(LogRequestResource::class);

        $expectedLogCount = $resource->count();

        $client = $this->getClient();
        $client->request('GET', '/healthz');

        static::assertSame($expectedLogCount, $resource->count());
    }
}
