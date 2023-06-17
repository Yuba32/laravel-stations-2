<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Schedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
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

        $result = DB::transaction(function () use ($request) {
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
        $result = DB::transaction(function () use ($request, $id) {
            $movie = Movie::find($id);

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
        if ($movie == null) {
            return response('', 404);
        }
        return view('adminEditMovie', compact('movie'));
    }

    public function destroy($id)
    {
        $movie = movie::find($id);

        if ($movie == null) {
            return response('', 404);
        }

        $result = $movie->delete();

        if ($result == 0) {
            $flashmessage = "削除に成功しました.";
            return redirect()->route('movie.list')->with('message.success', $flashmessage);
        } else {
            $flashmessage = "エラーが発生しました.";
            return redirect()->route('movie.list')->with('message.error', $flashmessage);
        }
    }

    public function getallschedules()
    {
        $movies = Movie::with('schedules')->get();
        return view('adminShowAllSchedule', compact('movies'));
    }

    public function getschedulebyid($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule == null) {
            return response('', 404);
        }
        return view('adminShowSchedulebyid', compact('schedule'));
    }

    public function createschedulemenu($id)
    {
        return view('adminCreateSchedule', ['id' => $id]);
    }


    public function createschedule(Request $request, $id)
    {
        $result = DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'movie_id' => 'required',
                'start_time_date' => ['required', 'date_format:Y-m-d'],
                'start_time_time' => ['required', 'date_format:H:i'],
                'end_time_date' => ['required', 'date_format:Y-m-d'],
                'end_time_time' => ['required', 'date_format:H:i'],
            ]);

            if ($movie == null) {
                return response('', 404);
            }

            $schedule = new Schedule;
            // $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_time_date . ' ' . $request->start_time_time);
//            $start_time = Carbon::create($request->start_time_date . ' ' . $request->start_time_time);
            $start_time = $request->start_time_date . ' ' . $request->start_time_time;
            // $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_time_date . ' ' . $request->end_time_time);
//            $end_time = Carbon::create($request->end_time_date . ' ' . $request->end_time_time);
            $end_time = $request->end_time_date . ' ' . $request->end_time_time;


            $schedule->movie_id = $request->movie_id;
            $schedule->start_time = $start_time;
            $schedule->end_time = $end_time;

            $schedule->save();
        });
        if ($result == 0) {
            $flashmessage = "エラーが発生しました.";
//             return redirect()->route('schedule.create', $id)->with('message.success', $flashmessage);
            return redirect('error', 500);
        } else {
            $flashmessage = "スケジュールを作成しました.";
            return redirect()->route('schedule.create', $id)->with('message.success', $flashmessage);
        }
    }

    public function storeschedule(Request $request, $id)
    {
        $movie = Movie::find($id);
        if ($movie == null) {
            return response('', 404);
        }
        $result = DB::transaction(function () use ($request, $id) {
            $validated = $request->validate([
                'movie_id' => 'required',
                'start_time_date' => ['required', 'date_format:Y-m-d'],
                'start_time_time' => ['required', 'date_format:H:i'],
                'end_time_date' => ['required', 'date_format:Y-m-d'],
                'end_time_time' => ['required', 'date_format:H:i'],
            ]);

            $schedule = new Schedule;
//            $start_time = Carbon::createFromFormat('Y-m-d H:i', $request->start_time_date . ' ' . $request->start_time_time)->format('Y-m-d H:i:s');
//            $end_time = Carbon::createFromFormat('Y-m-d H:i', $request->end_time_date . ' ' . $request->end_time_time)->format('Y-m-d H:i:s');
            $start_time = Carbon::parse($request->start_time_date . ' ' . $request->start_time_time)->format('Y-m-d H:i');
            $end_time = Carbon::parse($request->end_time_date . ' ' . $request->end_time_time)->format('Y-m-d H:i');


            $schedule->movie_id = $id;
            $schedule->start_time = $start_time;
            $schedule->end_time = $end_time;

            $schedule->save();
        });
        if ($result == 0) {
            $flashmessage = "エラーが発生しました.";
            return redirect()->route('schedule.create', $id)->with('message.success', $flashmessage);
        } else {
            $flashmessage = "スケジュールを作成しました.";
            return redirect()->route('schedule.create', $id)->with('message.success', $flashmessage);
        }
    }


    public function editschedule($scheduleId)
    {
        $schedule = Schedule::find($scheduleId);

        if ($schedule == null) {
            return response('', 404);
        }

        return view('adminEditSchedule', compact('schedule'));
    }

    public function updateschedule(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if ($schedule == null) {
            return response('', 404);
        }

        $validated = $request->validate([
            'movie_id' => 'required',
            'start_time_date' => ['required', 'date_format:Y-m-d'],
            'start_time_time' => ['required', 'date_format:H:i'],
            'end_time_date' => ['required', 'date_format:Y-m-d'],
            'end_time_time' => ['required', 'date_format:H:i'],
        ]);

        //check format is correct(YYYY-MM-DD H:i)
        $rules =
            //日付時刻を結合
        $start_time = Carbon::parse($request->start_time_date . ' ' . $request->start_time_time)->format('Y-m-d H:i');
        $end_time = Carbon::parse($request->end_time_date . ' ' . $request->end_time_time)->format('Y-m-d H:i');

        $schedule->start_time = $start_time;
        $schedule->end_time = $end_time;

        //更新処理
        $schedule->save();
        if ($schedule == null) {
            return redirect()->route('schedule.edit', $id)->with('message.success', '更新に失敗しました.');
        } else {
            return redirect()->route('schedule.edit', $id)->with('message.success', '更新に成功しました.');
        }
    }


    public function destroyschedule($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule == null) {
            return response('', 404);
        }
        $schedule->delete();
        return redirect()->route('schedule.getall')->with('message.success', '削除に成功しました.');
    }

    public function adminmovieinfo($id)
    {
//        $movie = Movie::find($id);
        $movie = Movie::with('schedules')->find($id);
        if ($movie == null) {
            return response('', 404);
        }
//        $schedules = $movie->schedules()->orderBy('start_time')->get();
        return view('adminMovieInfo', compact('movie'));
    }
}
