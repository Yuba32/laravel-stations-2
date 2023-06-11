<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Sheet;
use App\Models\Schedule;
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

  public function sheets()
  {
    $sheets = Sheet::all();
    $alphabet = range('a', 'z');

    foreach ($sheets as $sheet) {
      $sheet->rowint = array_search($sheet->row, $alphabet) + 1;
    }

    $sheets->sortBy([['rowint', 'asc'], ['column', 'asc']]);
    $columns = $sheets->max('column');
    $rows = $sheets->max('rowint');

    return view('getSheetsTable')->with(['sheet_list' => $sheets, 'columns' => $columns, 'rows' => $rows, 'alphabet' => $alphabet]);
  }

  public function movieinfo($id)
  {
    $movie = Movie::find($id);
    // $schedules = Schedule::where('movie_id', $id)->get();
    // $schedules->sortBy('start_time');
    $schedules = $movie->schedules()->orderBy('start_time')->get();

    return view('getMovieInfo')->with(['movie' => $movie, 'schedules' => $schedules]);
  }
}
