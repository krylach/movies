<?php

use App\Controllers\HomeController;
use App\Controllers\MovieController;
use App\Controllers\UserController;
use App\Middlewares\LoggedInMiddleware;
use App\Middlewares\NotLoggedInMiddleware;
use Engine\Route;

Route::get('/', [HomeController::class, 'index'], 'index');

Route::group(['prefix' => '/admin/movies', 'middlewares' => [LoggedInMiddleware::class]], function (Route $route) {
    $route->get('/', [MovieController::class, 'index'], 'movies.index');
    $route->post('/create', [MovieController::class, 'create'], 'movie.create');
    $route->post('/import', [MovieController::class, 'import'], 'movies.import');
});

Route::group(['prefix' => '/admin/movie', 'middlewares' => [LoggedInMiddleware::class]], function (Route $route) {
    $route->get('/{movie}/edit', [MovieController::class, 'edit'], 'movies.edit');
    $route->post('/{movie}/edit', [MovieController::class, 'update'], 'movies.update');
    $route->post('/{movie}/delete', [MovieController::class, 'delete'], 'movies.delete');
});

Route::group(['prefix' => '/login', 'middlewares' => [NotLoggedInMiddleware::class]], function (Route $route) {
    $route->get('/', [UserController::class, 'login'], 'users.login');
    $route->post('/', [UserController::class, 'authorize'], 'users.authorize');
});
