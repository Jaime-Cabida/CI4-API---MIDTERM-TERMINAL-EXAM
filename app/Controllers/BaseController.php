<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['cookie', 'date', 'security', 'menu', 'useraccess'];
    protected $session, $segment, $validation, $encrypter, $ApplicationModel, $data = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session          = service('session');
        $this->segment          = service('uri');
        $this->validation       = \Config\Services::validation();
        $this->encrypter        = \Config\Services::encrypter();
        $this->ApplicationModel = new ApplicationModel();

        // Safely get user data
        $username = $this->session->get('username');
        $role     = $this->session->get('role');

        $user = $username ? $this->ApplicationModel->getUser(username: $username) : null;

        // Safely get URI segments
        $segments = $this->segment->getSegments(); // returns array of all segments
        $segment = $segments[0] ?? '';            // first segment
        $subsegment = $segments[1] ?? '';         // second segment

        // Get menu categories only if user is logged in
        $MenuCategory = $role ? $this->ApplicationModel->getAccessMenuCategory($role) : [];

        $this->data = [
            'segment'      => $segment,
            'subsegment'   => $subsegment,
            'user'         => $user ?? ['fullname' => 'Guest'],
            'MenuCategory' => $MenuCategory
        ];
    }
}