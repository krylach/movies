<?php

namespace App\Models;

use Engine\Model;

class MovieFormat extends Model {
    protected string $table = 'formats';
    protected array $fillable = ['id', 'name'];
}
