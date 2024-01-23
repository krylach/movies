<?php

namespace App\Models;

use Engine\Model;

class Movie extends Model {
    protected string $table = 'movies';
    protected array $fillable = ['id', 'title', 'release_year', 'format_id'];

    public function format()
    {
        return MovieFormat::find($this->format_id);
    }

    public function stars()
    {
        $stars = Star::query()
            ->leftJoin('movie_stars', ['movie_stars.star_id', '=', 'stars.id'])
            ->andWhere('movie_stars.movie_id', $this->id)
            ->all();


        $collection = collect([]);
        foreach ($stars as $star) {
            $collection->add($star);
        }

        return $collection;
    }
}
