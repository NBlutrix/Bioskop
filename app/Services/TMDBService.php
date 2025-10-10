<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TMDBService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.key');
        $this->baseUrl = config('services.tmdb.base_url');
    }

    public function getPopularMovies($page = 1)
    {
        $response = Http::get("{$this->baseUrl}/movie/popular", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'page' => $page
        ]);
        return $response->json()['results'] ?? [];
    }

    public function getGenres()
    {
        $response = Http::get("{$this->baseUrl}/genre/movie/list", [
            'api_key' => $this->apiKey,
            'language' => 'en-US'
        ]);
        return $response->json()['genres'] ?? [];
    }
}
