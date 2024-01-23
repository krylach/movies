<?php

namespace App\Models;

use Engine\Model;

class User extends Model {
    protected string $table = 'users';
    protected array $fillable = ['id', 'login', 'email'];
}
