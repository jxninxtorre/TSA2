<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Home extends BaseController
{
    public function index()
    {
        $taskModel = new TaskModel();

        $data['tasks'] = $taskModel->getTasksByDate(date('Y-m-d'));
        $data['today'] = date('F j, Y'); 

        return view('welcome_message', $data);
    }
}