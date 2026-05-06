<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            if (session()->get('role') === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
            return redirect()->to('/user/dashboard');
        }

        return view('auth/login', ['title' => 'Login']);
    }

    public function loginProcess()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel
            ->where('username', $username)
            ->orWhere('email', $username)
            ->first();

        if (!$user) {
            session()->setFlashdata('error', 'Username atau email tidak ditemukan!');
            return redirect()->to('/login')->withInput();
        }

        if (!password_verify($password, $user['password'])) {
            session()->setFlashdata('error', 'Password salah!');
            return redirect()->to('/login')->withInput();
        }

        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);

        session()->setFlashdata('success', 'Selamat datang, ' . $user['username'] . '!');

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        return redirect()->to('/user/dashboard');
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('auth/register', ['title' => 'Register']);
    }

    public function registerProcess()
    {
        $rules = [
            'username'         => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'role'             => 'required|in_list[admin,user]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/register')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'phone'    => $this->request->getPost('phone'),
            'role'     => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }
}