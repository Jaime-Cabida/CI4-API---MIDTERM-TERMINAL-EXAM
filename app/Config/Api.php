<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Api extends BaseConfig
{
    public $baseURL;
    public $apiKey;

    public function __construct()
    {
        $this->baseURL = getenv('API_BASE_URL');
        $this->apiKey  = getenv('API_KEY');
    }
}