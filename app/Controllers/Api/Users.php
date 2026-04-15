<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    public function index()
    {
        return $this->respond([
            'status' => 200,
            'message' => 'Users API working successfully'
        ]);
    }
}