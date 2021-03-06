<?php
/**
 * run it with phpunit --group git-pre-push
 */
namespace App\Tests\Api;

use App\Tests\Common\ApiAbstract;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Quick test on all login pages
 * @package App\Tests\Api
 */
class ApiDocTest extends ApiAbstract
{
    public $uriLogin;
    public $uriSecured;
    public $token;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->uriLogin = $this->getRouter()->generate('api_login', []);
        $this->uriSecured= $this->getRouter()->generate('api_ping_secureds_get_collection', []);

        $this->client = $client = $this->getClient();
    }

    /**
     * @group git-pre-push
     */
    public function testApiDocISAvailable()
    {
        $errMsg = sprintf("route: %s", $this->uriSecured);
        $headers = $this->prepareHeaders($this->headers);

        $uri = $this->router->generate('api_doc', ['format' => 'json', 'spec_version' => 3, ], Router::NETWORK_PATH);
        $client = $this->client;
        $client->request(
            'GET',
            $uri,
            [],
            [],
            $headers
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $errMsg);
        $this->assertStringStartsWith('application/json', $client->getResponse()->headers->get('content-type'), $errMsg);
    }
}
