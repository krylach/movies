<?php

namespace App\Actions\Movie;

use App\Actions\Traits\HasPrepared;
use App\Models\Movie;
use App\Models\MovieStars;
use Engine\Session;
use Progsmile\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class UpdateMovieAction
{
    use HasPrepared;

    private Movie $movie;
    private Request $request;

    public function __construct(Movie $movie, Request $request)
    {
        $this->movie = $movie;
        $this->request = $request;
    }

    public function execute()
    {
        $data = $this->preparation(
            $this->request->request->all()
        );

        $validate = $this->validation($data);

        if (!$validate->isFail()) {
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

            Session::set("success", "A movie with the title <b>\"{$this->movie->title}\"</b> was successfully updated");
        }

        return redirect("/admin/movie/{$this->movie->id}/edit");
    }

    public function validation($data)
    {
        $validationCreateMovie = new ValidationMovie;

        return $validationCreateMovie->execute($data);
    }
}
