<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

    $validated = $request->validate([
      'title' => 'required|unique:movies',
      'image_url' => 'required|url',
      'published_year' => 'required',
      'is_showing' => 'required',
      'description' => 'required',
    ]);


    $movie = new Movie;
    $movie->title = $request->title;
    $movie->image_url = $request->image_url;
    $movie->published_year = $request->published_year;
    $movie->is_showing = $request->is_showing;
    $movie->description = $request->description;

    if ($movie->save()) {
      $flashmessage = "エラーが発生しました.";
      return redirect('/admin/movies', 302)->with('message.error', $flashmessage);
    } else {
      $flashmessage = "保存に成功しました.";
      return redirect('/admin/movies', 200)->with('message.success', $flashmessage);
    }
  }
}
