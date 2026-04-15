<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        // Redirect if already logged in
        if (session()->get('isLoggedIn') === TRUE) {
            return redirect()->to(base_url('dashboard'));
        }

        // Validate login form input
        if (!$this->validate([
            'inputEmail' => 'required|valid_email',
            'inputPassword' => 'required'
        ])) {
            return view('pages/commons/login');
        }

        // Get trimmed input
        $inputEmail    = trim($this->request->getPost('inputEmail'));
        $inputPassword = trim($this->request->getPost('inputPassword'));

        // Get user by username/email
        $user = $this->ApplicationModel->getUser($inputEmail);

        if (!$user) {
            session()->setFlashdata('notif_error', '<b>Your ID or Password is Wrong!</b>');
            return redirect()->to(base_url());
        }

        // Verify password
        if (!password_verify($inputPassword, $user['password'])) {
            session()->setFlashdata('notif_error', '<b>Your ID or Password is Wrong!</b>');
            return redirect()->to(base_url());
        }

        // Set session
        session()->set([
            'id'         => $user['userID'],
            'username'   => $user['username'],
            'fullname'   => $user['fullname'],
            'role'       => $user['role_id'],
            'isLoggedIn' => TRUE
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }

    public function forbiddenPage()
    {
        $data = array_merge($this->data, [
            'title' => 'Forbidden Page'
        ]);
        return view('pages/commons/forbidden', $data);
    }

    public function register()
    {
        return view('pages/commons/register');
    }

    public function registration()
    {
        if (!$this->validate([
            'inputFullname' => 'required',
            'inputEmail'    => ['label' => 'Email', 'rules' => 'required|valid_email|is_unique[users.username]'],
            'inputPassword' => 'required',
            'inputPassword2'=> ['label' => 'Password Confirmation', 'rules' => 'matches[inputPassword]']
        ])) {
            $data = array_merge($this->data, [
                'title' => 'Register Page',
            ]);

            session()->setFlashdata('notif_error', 
                $this->validation->getError('inputFullname') . ' ' .
                $this->validation->getError('inputEmail') . ' ' .
                $this->validation->getError('inputPassword2')
            );

            return view('pages/commons/register', $data);
        }

        // Get trimmed input for registration
        $inputFullname = trim($this->request->getPost('inputFullname'));
        $inputEmail    = trim($this->request->getPost('inputEmail'));
        $inputPassword = $this->request->getPost('inputPassword'); // raw password

        $dataUser = [
            'inputFullname' => $inputFullname,
            'inputUsername' => $inputEmail,
            'inputPassword' => $inputPassword, // will be hashed in createUser()
            'inputRole'     => 1
        ];

        $this->ApplicationModel->createUser($dataUser);

        session()->setFlashdata('notif_success', '<b>Registration Successfully!</b> Please login with your account.');
        return redirect()->to(base_url());
    }
}