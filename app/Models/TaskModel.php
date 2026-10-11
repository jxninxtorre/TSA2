<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['title', 'status', 'task_date', 'created_at', 'is_archived'];

    protected $validationRules = [
        'title'     => 'required|max_length[255]',
        'task_date' => 'required|valid_date[Y-m-d]',
    ];

    protected $validationMessages = [
        'title'     => ['required' => 'Title is required.'],
        'task_date' => [
            'required'   => 'Task date is required.',
            'valid_date' => 'Task date must be a valid date.',
        ],
    ];

    public function getTasksByDate(?string $date = null): array
    {
        $date = $date ?? date('Y-m-d');

        return $this->where('task_date', $date)
                    ->where('is_archived', 0)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function getAllTasksOrderedByDate(): array
    {
        return $this->where('is_archived', 0)
                    ->orderBy('task_date', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function findActive(int $id): ?array
    {
        return $this->where('is_archived', 0)->find($id);
    }

    public function archive(int $id): bool
    {
        return $this->update($id, ['is_archived' => 1]);
    }
}