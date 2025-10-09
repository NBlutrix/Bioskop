<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoviesController extends Controller
{
    // Vrati sve filmove sa povezanim žanrovima, ocenama i komentarima
    public function index() {
        return Movie::with('genres', 'ratings', 'comments')->get();
    }

    // Vrati jedan film po ID-u sa svim povezanim podacima
    public function show($id) {
        return Movie::with('genres', 'ratings', 'comments')->findOrFail($id);
        // findOrFail baca grešku 404 ako film ne postoji
    }

    // Kreira novi film i povezuje ga sa žanrovima
    public function store(Request $request) {
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
