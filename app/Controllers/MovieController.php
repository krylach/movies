<?php

namespace App\Controllers;

use App\Actions\Movie\BuildMoviesAction;
use App\Actions\Movie\CreateMovieAction;
use App\Actions\Movie\ImportMovieAction;
use App\Actions\Movie\UpdateMovieAction;
use App\Models\Movie;
use App\Models\MovieFormat;
use App\Models\Star;
use Engine\Session;
use Symfony\Component\HttpFoundation\Request;

class MovieController
{
    public function index(Request $request)
    {
        $parameters = $request->query->all();

        return view('crud.movies.index')
            ->multipleAssign([
                'movies'    => $this->buildMovies($request),
                'formats'   => $this->buildFormats(),
                'stars'     => $this->buildStars(),
                'request' => $request,
                'title' => 'Movies',
                'errors' => Session::getAndDelete('errors'),
                'success' => Session::getAndDelete('success'),
                'filter' => !empty($parameters) ? $parameters : [
                    'title' => '',
                    'star' => '',
                ],
                'entities' => [
                    'Movies' => $request->getRequestUri(),
                ]
            ])
            ->render();
    }

    public function edit(Request $request, Movie $movie)
    {
        return view('crud.movies.edit')
            ->multipleAssign([
                'title' => $movie->title ?? '' . " edit",
                'movie' => $movie,
                'errors' => Session::getAndDelete('errors'),
                'success' => Session::getAndDelete('success'),
                'formats'   => $this->buildFormats(),
                'stars'     => $this->buildStars(),
            ])
            ->render();
    }

    public function delete(Movie $movie)
    {
        Session::set("success", "A movie with the title <b>\"{$movie->title}\"</b> was successfully deleted");
        $movie->delete();

        return redirect('/admin/movies');
    }

    public function update(Request $request, Movie $movie)
    {
        $updateMovieAction = new UpdateMovieAction($movie, $request);

        return $updateMovieAction->execute();
    }

    public function create(Request $request)
    {
        $createMovieAction = new CreateMovieAction($request);

        return $createMovieAction->execute();
    }

    public function import(Request $request)
    {
        $importMovieAction = new ImportMovieAction($request);

        return $importMovieAction->execute();
    }

    private function buildStars()
    {
        $builder = Star::where('id', null, 'is not');
        
        return $builder->all();
    }

    private function buildFormats()
    {
        $builder = MovieFormat::where('id', null, 'is not');

        return $builder->all();
    }

    private function buildMovies(Request $request)
    {
        $buildMoviesAction = new BuildMoviesAction($request);

        return $buildMoviesAction->execute();
    }
}
