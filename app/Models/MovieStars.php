<?php

namespace App\Models;

use Engine\Model;

class MovieStars extends Model {
    protected string $table = 'movie_stars';
    protected array $fillable = ['id', 'movie_id', 'star_id'];

    public function movie()
    {
        return Movie::find($this->movie_id);
    }

    public function star()
    {
        return Star::find($this->star_id);
    }
}
