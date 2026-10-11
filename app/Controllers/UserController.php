<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        // Kukunin ang single demo record
        $data['user'] = $userModel->getDemoUser();

        return view('user/profile', $data);
    }
}