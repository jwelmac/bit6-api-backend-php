<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

// Load api parameters from yaml file
$api = Yaml::parse(file_get_contents(__DIR__.'/test.yaml'));

// Read Bit6 API key and secret from environment variables
$apiKey = $api['key'];
$apiSecret = $api['secret'];
$user = $api['user'];
