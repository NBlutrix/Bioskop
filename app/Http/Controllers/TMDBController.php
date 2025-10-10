<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Services\TMDBService;
use Illuminate\Http\Request;

class TMDBController extends Controller
{
    protected $tmdb;

    public function __construct(TMDBService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    public function import()
    {
        // Uvoz žanrova
        $genres = $this->tmdb->getGenres();
        foreach ($genres as $genre) {
            Genre::updateOrCreate(
                ['tmdb_id' => $genre['id']],
                ['name' => $genre['name']]
            );
        }

        // Uvoz popularnih filmova
        $movies = $this->tmdb->getPopularMovies();
        foreach ($movies as $movie) {
            $newMovie = Movie::updateOrCreate(
                ['tmdb_id' => $movie['id']],
                [
                    'title' => $movie['title'],
                    'description' => $movie['overview'],
                    'poster_path' => $movie['poster_path'],
                    'release_date' => $movie['release_date'] ?? null,
                    'rating' => $movie['vote_average'] ?? 0,
                ]
            );

            // Poveži žanrove
            if (!empty($movie['genre_ids'])) {
                $genreIds = Genre::whereIn('tmdb_id', $movie['genre_ids'])->pluck('id');
                $newMovie->genres()->sync($genreIds);
            }
        }

        return response()->json(['message' => 'Movies imported successfully']);
    }
}
