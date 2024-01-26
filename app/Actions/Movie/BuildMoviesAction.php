<?php

namespace App\Actions\Movie;

use App\Models\Movie;
use App\Models\MovieStars;
use App\Models\Star;
use Symfony\Component\HttpFoundation\Request;

class BuildMoviesAction
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function execute()
    {
        $builder = Movie::query();

        if ($sort = $this->request->query->get('sort')) {
            $builder->orderBy('title', $sort);
        }

        if ($title = $this->request->query->get('title')) {
            $title = str_replace('+', ' ', $title);
            $builder->andWhere('title', "%$title%", 'like');
        }

        if ($star = $this->request->query->get('star')) {
            $star = str_replace('+', ' ', $star);
            $stars = Star::where('name', "%$star%", 'like')->all();
            $starsId = pluck($stars, 'id');

            if ($starsId) {
                $movieStars = MovieStars::query()
                    ->whereIn('star_id', $starsId)
                    ->all();

                $moviesId = pluck($movieStars, 'movie_id');
                $builder->whereIn('id', $moviesId);
            }
        }

        return $builder->all();
    }
}
