<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ApplicationModel;

class ProfileController extends BaseController
{
    protected $userModel;
    protected $appModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->appModel  = new ApplicationModel();
    }

    public function show()
    {
        $userID = session()->get('id');

        if (!$userID) {
            return redirect()->to(base_url())->with('notif_error', 'Please login first.');
        }

        $user   = $this->userModel->find($userID);
        $MenuCategory = $this->appModel->getAccessMenuCategory($user['role'] ?? 1);

        $uri        = service('uri');
        $segment    = $uri->getSegment(1);
        $subsegment = $uri->getSegment(2);

        $data = [
            'user'         => $user,
            'MenuCategory' => $MenuCategory,
            'segment'      => $segment,
            'subsegment'   => $subsegment
        ];

        return view('profile/show', $data);
    }

    public function edit()
    {
        $userID = session()->get('id');

        if (!$userID) {
            return redirect()->to(base_url())->with('notif_error', 'Please login first.');
        }

        $user   = $this->userModel->find($userID);
        $MenuCategory = $this->appModel->getAccessMenuCategory($user['role'] ?? 1);

        $uri        = service('uri');
        $segment    = $uri->getSegment(1);
        $subsegment = $uri->getSegment(2);

        $data = [
            'user'         => $user,
            'MenuCategory' => $MenuCategory,
            'segment'      => $segment,
            'subsegment'   => $subsegment
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        $userID = session()->get('id');

        if (!$userID) {
            return redirect()->to(base_url())->with('notif_error', 'Please login first.');
        }

        $user = $this->userModel->find($userID);

        // Validation rules
        $rules = [
            'fullname'   => 'required',
            'username'   => "required|valid_email|is_unique[users.username,id,{$userID}]",
            'student_id' => 'required',
            'course'     => 'required',
            'year_level' => 'required|integer',
            'section'    => 'required',
            'phone'      => 'required',
            'address'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle profile image upload
        $file     = $this->request->getFile('profile_image');
        $fileName = $user['profile_image'] ?? '';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext      = $file->getExtension();
            $fileName = 'avatar_' . $userID . '_' . time() . '.' . $ext;

            if (!empty($user['profile_image'])) {
                $oldPath = FCPATH . 'uploads/profiles/' . $user['profile_image'];
                if (file_exists($oldPath)) unlink($oldPath);
            }

            $file->move(FCPATH . 'uploads/profiles/', $fileName);
        }

        // Prepare data for update
        $updateData = [
            'fullname'      => $this->request->getPost('fullname'),
            'username'      => $this->request->getPost('username'),
            'student_id'    => $this->request->getPost('student_id'),
            'course'        => $this->request->getPost('course'),
            'year_level'    => $this->request->getPost('year_level'),
            'section'       => $this->request->getPost('section'),
            'phone'         => $this->request->getPost('phone'),
            'address'       => $this->request->getPost('address'),
            'profile_image' => $fileName
        ];

        // Update user in DB
        $this->userModel->updateProfile($userID, $updateData);

        // Update session values individually
        session()->set([
            'username' => $updateData['username'],
            'fullname' => $updateData['fullname']
        ]);

        session()->setFlashdata('success', 'Profile updated successfully.');
        return redirect()->to('/profile');
    }
}