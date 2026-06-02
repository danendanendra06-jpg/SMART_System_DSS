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
            return redirect()->to(base_url('home'));
        }

        $data = [
            'title' => 'Login | SPK SMART'
        ];
        return view('auth/login', $data);
    }

    public function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id_user'    => $user['id_user'],
                    'nama'       => $user['nama'],
                    'email'      => $user['email'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true
                ];
                session()->set($sessionData);
                return redirect()->to(base_url('home'));
            } else {
                session()->setFlashdata('error', 'Password salah.');
                return redirect()->to(base_url('auth/login'));
            }
        } else {
            session()->setFlashdata('error', 'Email tidak ditemukan.');
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('home'));
        }

        $data = [
            'title' => 'Register | SPK SMART'
        ];
        return view('auth/register', $data);
    }

    public function processRegister()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('validation', $this->validator);
            return redirect()->to(base_url('auth/register'))->withInput();
        }

        $this->userModel->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => 'user'
        ]);

        session()->setFlashdata('success', 'Registrasi berhasil. Silakan login.');
        return redirect()->to(base_url('auth/login'));
    }

    public function reset_password()
    {
        $data = [
            'title' => 'Reset Password | SPK SMART'
        ];
        return view('auth/reset_password', $data);
    }

    public function processReset()
    {
        // Fitur simulasi reset password sederhana untuk tugas
        $email = $this->request->getPost('email');
        $new_password = $this->request->getPost('new_password');

        $user = $this->userModel->where('email', $email)->first();
        if($user) {
            $this->userModel->update($user['id_user'], [
                'password' => password_hash($new_password, PASSWORD_BCRYPT)
            ]);
            session()->setFlashdata('success', 'Password berhasil direset. Silakan login dengan password baru.');
            return redirect()->to(base_url('auth/login'));
        } else {
            session()->setFlashdata('error', 'Email tidak terdaftar.');
            return redirect()->to(base_url('auth/reset_password'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }
}
