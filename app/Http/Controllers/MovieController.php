<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;


class MovieController extends Controller
{
  public function index(Request $request)
  {
    $movies = Movie::orderBy('id', 'desc');
    $movie_list = $movies->paginate(20);

    $query = Movie::query();

    if ($request != null) {
      $is_showing = $request->is_showing;
      $keyword = $request->keyword;

      if (isset($keyword)) {
        if (isset($is_showing)) {
          // $query->where(['is_showing', '=', $is_showing])->andWhere($kwd);
          $query->where('is_showing', '=', $is_showing)->where(function ($query) use ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
          });
        } else {
          $query->where('title', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
        }
      } else {
        if (isset($is_showing)) {
          $query->where('is_showing', '=', $is_showing);
        }
      }
    }

    $movie_list = $query->paginate(20);

    return view('getMovies')->with(['movie_list' => $movie_list, 'is_showing' => $is_showing, 'keyword' => $keyword]);
  }
}
