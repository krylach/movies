<?php

namespace App\Actions\Movie;

use App\Models\Movie;
use App\Models\MovieStars;
use Progsmile\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class UpdateMovieAction
{
    private Movie $movie;
    private Request $request;

    public function __construct(Movie $movie, Request $request)
    {
        $this->movie = $movie;
        $this->request = $request;
    }

    public function execute()
    {
        if ($this->validation()) {
            $data = $this->request->request->all();
            $starsFromRequest = $data['stars'];
            unset($data['stars']);

            $this->movie->update($data);
            if ($movieStars = MovieStars::where('movie_id', $this->movie->id)->all()) {
                foreach ($movieStars as $movieStar) {
                    $movieStar->delete();
                }

                foreach ($starsFromRequest as $starId) {
                    MovieStars::create(['star_id' => $starId, 'movie_id' => $this->movie->id]);
                }
            }
        }

        return redirect("/admin/movie/{$this->movie->id}/edit");
    }

    private function validation()
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
