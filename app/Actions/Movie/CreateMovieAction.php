<?php

namespace App\Actions\Movie;

use App\Actions\Traits\HasPrepared;
use App\Models\Movie;
use App\Models\MovieStars;
use App\Rules\IsNotEmpty;
use Engine\Session;
use Progsmile\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class CreateMovieAction
{
    use HasPrepared;

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function execute()
    {
        $data = $this->preparation(
            $this->request->request->all()
        );

        $validate = $this->validation($data);

        if (!$validate->isFail()) {
            $stars = $data['stars'];
            unset($data['stars']);

            $movie = Movie::create($data);

            if ($movie && $stars) {
                foreach ($stars as $starId) {
                    MovieStars::create(['star_id' => $starId, 'movie_id' => $movie->id]);
                }
            }

            if ($movie) {
                Session::set("success", "A movie with the title <b>\"{$movie->title}\"</b> was successfully added");
            }
        }

        return redirect('/admin/movies');
    }

    public function validation($data)
    {
        $validationCreateMovie = new ValidationMovie;

        return $validationCreateMovie->execute($data);
    }
}
