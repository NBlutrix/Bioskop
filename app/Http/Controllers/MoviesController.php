<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MoviesController extends Controller
{
    // Vrati sve filmove sa povezanim žanrovima, ocenama i komentarima
    public function index(Request $request) {
        $query = Movie::with('genres', 'ratings', 'comments');

    if ($request->has('genre')) {
        $query->whereHas('genres', fn($q) => $q->where('name', $request->genre));
    }

    if ($request->has('sort')) {
        $query->orderBy('release_date', $request->sort);
    }

    if ($request->has('search')) {
    $query->where('title', 'like', '%' . $request->search . '%');
    }

    return $query->paginate(10);
    }

    // Vrati jedan film po ID-u sa svim povezanim podacima
    public function show($id) {
        return Movie::with('genres', 'ratings', 'comments')->findOrFail($id);
        // findOrFail baca grešku 404 ako film ne postoji
    }

    // Kreira novi film i povezuje ga sa žanrovima
    public function store(Request $request) {

        //VALIDACIJA
        $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'poster' => 'nullable|url',
    'release_date' => 'nullable|date',
    'genres' => 'nullable|array'
]);

        $movie = Movie::create($request->all()); // Kreira film sa svim podacima iz zahteva

        // Ako zahtev sadrži žanrove, poveži film sa njima
        if ($request->genres) {
            $movie->genres()->sync($request->genres);
            // sync() povezuje film sa prosleđenim ID-jevima žanrova
        }

        return response()->json($movie, 201); 
        // 201 = "Created", vraća kreirani film kao JSON
    }

    // Ažurira postojeći film i njegove žanrove
    public function update(Request $request, $id) {

        $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'poster' => 'nullable|url',
    'release_date' => 'nullable|date',
    'genres' => 'nullable|array'
]);

        $movie = Movie::findOrFail($id); // Pronađi film po ID-u
        $movie->update($request->all()); // Ažuriraj sve podatke iz zahteva

        if ($request->genres) {
            $movie->genres()->sync($request->genres); 
            // Ažuriraj žanrove filma
        }

        return response()->json($movie); 
        // Vraća ažurirani film kao JSON
    }

    // Briše film po ID-u
    public function destroy($id) {
        Movie::destroy($id); // Briše film iz baze
        return response()->json(null, 204); 
        // 204 = "No Content", znači uspešno obrisano
    }
}
