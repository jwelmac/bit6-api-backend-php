<?php

namespace Bit6;

use \Httpful\Request;
use \Symfony\Component\Yaml\Yaml;

class BackendApi
{
    private $base_url;
    private $routes;
    private $paths;

    /**
    * Construct new class object
    */
    public function __construct($apiKey, $apiSecret, $dev = false)
    {
        if (!$apiKey || !$apiSecret) {
            throw new \Exception("API key and/or secret not specified");
        }
        // Set the  request template
        $template = Request::init()
        ->authenticateWith($apiKey, $apiSecret);
        //Initiate request template
        Request::ini($template);

        // Get the bit6 routes from routes.yaml
        $this->routes = Yaml::parse(file_get_contents(__DIR__.'/routes.yaml'));

        // Set the base url for requests
        $this->base_url = $dev ? $this->routes['dev'] : $this->routes['prod'];
        $this->base_url .= '/backend/1/';

        // Set the paths to query
        $backend = Yaml::parse(file_get_contents($this->routes['backend']));
        $this->paths = $backend['paths'];
    }

    /**
    * Get a specific user's information
    */
    public function user($name, $uri = 'usr:')
    {
        $id = $this->getUID($uri.$name);
        return $this->__request("/users/{$id}");
    }

    /**
    * Get a user uid
    */
    private function getUID($usr)
    {
        $allIdentities = $this->__request('/identities');
        foreach ($allIdentities as $identity) {
            if ($identity['id'] == $usr) {
                return $identity['user'];
            }
        }
    }

    /**
    * Make a request to the Bit6 backend API
    */
    public function __request($uri, $method = 'get', $json = true)
    {
        $response = Request::{$method}($this->base_url.$uri)->send();
        return $json ? json_decode($response, true) : $response;
    }
}
