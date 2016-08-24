<?php

namespace Bit6;

class BackendApiTest extends \PHPUnit_Framework_TestCase
{
    protected $api;

    protected function setUp()
    {
        global $apiKey, $apiSecret;
        $this->api = new BackendApi($apiKey, $apiSecret);
    }

    /**
    * Check for error message with missing parameters
    * @expectedException Exception
    */
    public function testFailedConstructor()
    {
        new BackendApi("", "");
    }

    /**
    * Check users information returned
    */
    public function testGetUserInformation()
    {
        global $user;
        $result = $this->api->user($user);
        $expected = "usr:".$user;
        $this->assertEquals($expected, $result['identities'][0]);
    }
}
