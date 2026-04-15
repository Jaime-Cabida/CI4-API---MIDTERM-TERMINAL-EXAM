<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ApplicationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        $userID = session()->get('id');
        if (!$userID) {
            return redirect()->to(base_url())->with('notif_error', 'Please login first.');
        }

        $model = new ApplicationModel();

        // Get current logged-in user
        $user = $model->getUser(false, $userID);

        // Get menu categories
        $MenuCategory = $model->getAccessMenuCategory($user['role']);

        // Get current URL segment for active menu highlight
        $uri = service('uri');
        $segment = $uri->getSegment(1); // first segment
        $subsegment = $uri->getSegment(2); // second segment (for submenu)

        $data = [
            'user' => $user,
            'MenuCategory' => $MenuCategory,
            'segment' => $segment,
            'subsegment' => $subsegment
        ];

        return view('pages/commons/dashboard', $data);
    }
}
