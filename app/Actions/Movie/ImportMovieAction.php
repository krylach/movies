<?php

namespace App\Actions\Movie;

use App\Models\Movie;
use App\Models\MovieFormat;
use App\Models\MovieStars;
use App\Models\Star;
use Engine\Session;
use Symfony\Component\HttpFoundation\Request;

class ImportMovieAction
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function execute()
    {
        $importFile = $this->request->files->get('import_file');
        $name = md5('uploaded_'.time());

        if (!$importFile) {
            return redirect('/admin/movies');
        }

        if ($importFile->move(tmp_path('/uploaded'), $name)) {
            $movies = $this->collectMovies($name);
            
            $this->createMovies($movies);
        }

        return redirect('/admin/movies');
    }

    private function createMovies($movies)
    {
        $updated = 0;
        $created = 0;

        foreach ($movies as $movie) {
            
            $stars = $movie['stars'];
            unset($movie['stars']);

            $format = MovieFormat::where('name', $movie['format'])->first();
            unset($movie['format']);
            $movie['format_id'] = $format->id;

            $movieModel = Movie::where('title', $movie['title'])->first();
            if (!$movieModel)  {
                $movieModel = Movie::create($movie); 
                $created++;
            } else {
                $movieModel->update($movie);
                $updated++;
            }

            foreach ($stars as $star) {
                $starModel = Star::where('name', $star)->first();
                if (!$starModel) {
                    $starModel = Star::create(['name' => $star]);
                }
                
                MovieStars::create(['star_id' => $starModel->id, 'movie_id' => $movieModel->id]);
            }
        }

        Session::set('success', "$updated films updated, $created films created");
    }

    private function collectMovies($fileName)
    {
        $import = file_get_contents(tmp_path("/uploaded/$fileName"));
        unlink(tmp_path("/uploaded/$fileName"));
        $titles = [];
        preg_match_all('/(Title: )(.*?)\n/', $import, $titles);

        $releaseYears = [];
        preg_match_all('/(Release Year: )(.*?)\n/', $import, $releaseYears);

        $formats = [];
        preg_match_all('/(Format: )(.*?)\n/', $import, $formats);

        $stars = [];
        preg_match_all('/(Stars: )(.*?)\n/', $import, $stars);

        $movies = [];
        foreach ($titles[2] as $key => $title) {
            $movies[] = [
                'title' => $title,
                'release_year' => $releaseYears[2][$key] ?? '',
                'format' => $formats[2][$key] ?? '',
                'stars' => explode(', ', $stars[2][$key]) ?? [],
            ];
        }

        return $movies;
    }
}
