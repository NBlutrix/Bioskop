<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index($movieId) {
    return Comment::where('movie_id', $movieId)->with('user')->get();
}

public function store(Request $request, $movieId) {

    $request->validate(['score' => 'required|integer|min:1|max:5']);

    $comment = Comment::create([
        'user_id' => $request->user()->id,
        'movie_id' => $movieId,
        'content' => $request->content
    ]);
    return response()->json($comment, 201);
}

public function update(Request $request, $id) {
    $comment = Comment::findOrFail($id);
    $comment->update($request->only('content'));
    return response()->json($comment);
}

public function destroy($id) {
    Comment::destroy($id);
    return response()->json(null, 204);
}
}
