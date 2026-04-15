<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentInfoModel;
use App\Models\ApplicationModel;

class Student extends BaseController
{
    public function index()
    {
        $studentModel     = new StudentInfoModel();
        $applicationModel = new ApplicationModel();

        // Fetch all students
        $students = $studentModel->findAll();

        // Get current logged-in user from session
        $username = session()->get('username'); // use username stored in session
        $user     = [];

        if ($username) {
            // Fetch full user info from DB using ApplicationModel
            $user = $applicationModel->getUser(username: $username);
        }

        // If $user is empty (no session or DB problem), fallback to a default user
        if (empty($user)) {
            $user = [
                'id'       => 0,
                'role_id'  => 1,
                'role'     => 1,
                'username' => 'Guest',
                'fullname' => 'Guest User'
            ];
        }

        // Ensure sidebar has 'role' key
        if (!isset($user['role'])) {
            $user['role'] = $user['role_id'];
        }

        // Fetch menu categories for this user's role
        $MenuCategory = $applicationModel->getAccessMenuCategory($user['role']);

        // Get URI segments for sidebar active states
        $segment    = service('uri')->getSegment(1) ?? '';
        $subsegment = service('uri')->getSegment(2) ?? '';

        // Pass data to the view
        return view('pages/commons/studentview', [
            'students'     => $students,
            'MenuCategory' => $MenuCategory,
            'user'         => $user,
            'segment'      => $segment,
            'subsegment'   => $subsegment
        ]);
    }

    public function store()
    {
        $model = new StudentInfoModel();
        $data  = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'course' => $this->request->getPost('course'),
        ];
        $model->insert($data);
        return redirect()->to('/students');
    }

    public function delete($id)
    {
        $model = new StudentInfoModel();
        $model->delete($id);
        return redirect()->to('/students');
    }
}