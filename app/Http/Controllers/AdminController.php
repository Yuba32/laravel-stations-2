<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
  public function movies()
  {
    $movies = Movie::all();
    return view('getAdminMovieList', ['movies' => $movies]);
  }

  public function create()
  {
    return view('adminCreateMovie');
  }

  public function store(Request $request)
  {

    $result =  DB::transaction(function () use ($request) {
      $validated = $request->validate([
        'title' => 'required|unique:movies',
        'image_url' => 'required|url',
        'published_year' => 'required',
        'is_showing' => 'required',
        'description' => 'required',
        'genre' => 'required'
      ]);

      $movie = new Movie;
      $movie->title = $request->title;
      $movie->image_url = $request->image_url;
      $movie->published_year = $request->published_year;
      $movie->is_showing = $request->is_showing;
      $movie->description = $request->description;

      $genre_name = $request->genre;
      $genre_db = DB::table('genres');

      if ($genre_db->where('name', $genre_name)->exists()) {
        $genre_id = $genre_db->where('name', $genre_name)->value('id');
      } else {
        $genre = new Genre;
        $genre->name = $genre_name;
        $genre->save();
        $genre_id = $genre->id;
      }

      $movie->genre_id = $genre_id;
      $movie->save();
    });

    if ($result == 0) {
      $flashmessage = "エラーが発生しました.";
      return redirect('/admin/movies')->with('message.error', $flashmessage);
    } else {
      $flashmessage = "保存に成功しました.";
      return redirect('/admin/movies')->with('message.success', $flashmessage);
    }
  }

  public function update(Request $request, $id)
  {
    $result =  DB::transaction(function () use ($request, $id) {
      $movie =  Movie::find($id);

      $validated = $request->validate([
        'title' => 'required|unique:movies',
        'image_url' => 'required|url',
        'published_year' => 'required',
        'is_showing' => 'required',
        'description' => 'required',
        'genre' => 'required',
      ]);

      $movie->title = $request->title;
      $movie->image_url = $request->image_url;
      $movie->published_year = $request->published_year;
      $movie->is_showing = $request->is_showing;
      $movie->description = $request->description;

      $genre_name = $request->genre;
      $genre_db = DB::table('genres');
      $genre_id = "";

      if ($genre_db->where('name', $genre_name)->exists()) {
        $genre_id = $genre_db->where('name', $genre_name)->value('id');
      } else {
        $genre = new Genre;
        $genre->name = $genre_name;
        $genre->save();
        $genre_id = $genre->id;
      }

      $movie->genre_id = $genre_id;

      $movie->save();
    });

    if ($result == 0) {
      $flashmessage = "エラーが発生しました.";
      return redirect()->route('movie.edit', $request->id)->with('message.error', $flashmessage);
    } else {
      $flashmessage = "更新に成功しました.";
      return redirect()->route('movie.edit', $request->id)->with('message.success', $flashmessage);
    }
  }

  public function edit($id)
  {
    $movie = Movie::with('genre')->find($id);
    return view('adminEditMovie', compact('movie'));
  }

  public function destroy($id)
  {
    $movie = movie::find($id);

    if ($movie == null) {
      return response('', 404);
    }

    $result =  $movie->delete();

    if ($result == 0) {
      $flashmessage = "削除に成功しました.";
      return redirect()->route('movie.list')->with('message.success', $flashmessage);
    } else {
      $flashmessage = "エラーが発生しました.";
      return redirect()->route('movie.list')->with('message.error', $flashmessage);
    }
  }
}
