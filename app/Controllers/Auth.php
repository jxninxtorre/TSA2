<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session('user_id')) {
            return redirect()->to('/tasks');
        }

        return view('auth/login', ['title' => 'Login']);
    }

    public function attempt()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())->where('username', $username)->first();

        if (! $user || empty($user['password']) || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
        }

        session()->regenerate();
        session()->set([
            'user_id'  => $user['id'],
            'username' => $user['username'],
        ]);

        return redirect()->to('/tasks')->with('success', 'Logged in.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Logged out.');
    }
}