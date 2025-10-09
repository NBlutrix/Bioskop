<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatingsController extends Controller
{
    public function index($movieId) {
    return Rating::where('movie_id', $movieId)->with('user')->get();
}

public function store(Request $request, $movieId) {
    $rating = Rating::create([
        'user_id' => $request->user()->id,
        'movie_id' => $movieId,
        'score' => $request->score
    ]);
    return response()->json($rating, 201);
}

public function update(Request $request, $id) {
    $rating = Rating::findOrFail($id);
    $rating->update($request->only('score'));
    return response()->json($rating);
}

public function destroy($id) {
    Rating::destroy($id);
    return response()->json(null, 204);
}
}
