<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'name', 'full_name', 'email', 'password'];

    public function getDemoUser()
    {
        return $this->orderBy('id', 'ASC')->first();
    }
}