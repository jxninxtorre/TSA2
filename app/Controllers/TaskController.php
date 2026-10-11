<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends BaseController
{
    public function index()
    {
        $taskModel = new TaskModel();
        $data['tasks'] = $taskModel->getAllTasksOrderedByDate();

        return view('tasks/index', $data);
    }

    public function newTask()
    {
        return view('tasks/form', ['task' => null]);
    }

    public function create()
    {
        $model = new TaskModel();

        $data = [
            'title'       => trim((string) $this->request->getPost('title')),
            'status'      => $this->request->getPost('status') ?: 'pending',
            'task_date'   => $this->request->getPost('task_date'),
            'created_at'  => date('Y-m-d H:i:s'),
            'is_archived' => 0,
        ];

        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/tasks')->with('success', 'Task created.');
    }

    public function edit($id)
    {
        $task = (new TaskModel())->findActive((int) $id);

        if (! $task) {
            return redirect()->to('/tasks')->with('error', 'Task not found.');
        }

        return view('tasks/form', ['task' => $task]);
    }

    public function update($id)
    {
        $model = new TaskModel();

        if (! $model->findActive((int) $id)) {
            return redirect()->to('/tasks')->with('error', 'Task not found.');
        }

        $data = [
            'title'     => trim((string) $this->request->getPost('title')),
            'status'    => $this->request->getPost('status') ?: 'pending',
            'task_date' => $this->request->getPost('task_date'),
        ];

        if (! $model->update((int) $id, $data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/tasks')->with('success', 'Task updated.');
    }

    public function delete($id)
    {
        $model = new TaskModel();

        if (! $model->findActive((int) $id)) {
            return redirect()->to('/tasks')->with('error', 'Task not found.');
        }

        $model->archive((int) $id);

        return redirect()->to('/tasks')->with('success', 'Task archived.');
    }
}