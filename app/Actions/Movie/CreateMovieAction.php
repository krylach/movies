<?php

namespace App\Actions\Movie;

use App\Models\Movie;
use App\Models\MovieStars;
use Progsmile\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class CreateMovieAction
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function execute()
    {
        if ($this->validation()) {
            $data = $this->request->request->all();
            $stars = $data['stars'];
            unset($data['stars']);

            $movie = Movie::create($data);
            if ($movie && $stars) {
                foreach ($stars as $starId) {
                    MovieStars::create(['star_id' => $starId, 'movie_id' => $movie->id]);
                }
            }
        }

        return redirect('/admin/movies');
    }

    public function validation()
    {
        $rules = [
            'title' => ['required'],
            'release_year' => ['required', 'numeric', 'between:1900, 2024'],
            'format_id' => ['required', 'numeric'],
            'stars' => [],
        ];

        $validator = Validator::make(
            $this->request->request->all(),
            $rules,
        );

        return !$validator->fails();
    }
}
