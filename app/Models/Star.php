<?php

namespace App\Models;

use Engine\Model;

class Star extends Model {
    protected string $table = 'stars';
    protected array $fillable = ['id', 'name'];
}
