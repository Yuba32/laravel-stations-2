<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class AdminController extends Controller
{
  public function movies()
  {
    $movies = Movie::all();
    return view('getAdminMovieList', ['movies' => $movies]);
  }
}