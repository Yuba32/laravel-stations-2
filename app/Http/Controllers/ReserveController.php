<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Sheet;
use App\Models\Schedule;
use App\Models\Movie;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class ReserveController extends Controller
{
    public function sheetinfo($movie_id, $schedule_id, Request $request)
    {

        if (!($request->has('date'))) {
            //return error 400
            return response()->json(['message' => 'date is required'], 400);
        }
        $date = $request->date;


        $sheets = Sheet::all();
        if ($sheets == null) {
            //return error 400
            return response()->json(['message' => 'sheets not found'], 400);
        }
        $alphabet = range('a', 'z');

        foreach ($sheets as $sheet) {
            $sheet->rowint = array_search($sheet->row, $alphabet) + 1;
        }

        $sheets->sortBy([['rowint', 'asc'], ['column', 'asc']]);
        $columns = $sheets->max('column');
        $rows = $sheets->max('rowint');

        $schedule = Schedule::find($schedule_id);

        if ($schedule == null) {
            //return error 400
            return response()->json(['message' => 'schedule not found'], 400);
        }

        //予約済みの座席情報を取得
        $reserved = Reservation::where('schedule_id', $schedule_id)->where('date', $date)->get();

        $reserved_sheets = array();
        //予約済みの座席IDを配列に格納
        for ($i = 0; $i < count($reserved); $i++) {
            $reserved_sheets[$i] = $reserved[$i]->sheet_id;
        }

        // $screening_date = $request->date;

        return view('getReserveSheetsInfo')->with(['sheet_list' => $sheets, 'columns' => $columns, 'rows' => $rows, 'alphabet' => $alphabet, 'movie_id' => $movie_id, 'schedule_id' => $schedule_id, 'date' => $date, 'reserved_sheets' => $reserved_sheets]);
    }

    public function reserveform($movie_id, $schedule_id, Request $request)
    {
        //座席予約フォーム 予約ページ

        if (!($request->has('sheetId'))) {
            //return error 400
            return response()->json(['message' => 'sheetId is required'], 400);
        }
        if (!($request->has('date'))) {
            //return error 400
            return response()->json(['message' => 'date is required'], 400);
        }


        $schedule = Schedule::find($schedule_id);

        if ($schedule == null) {
            //return error 400
            return response()->json(['message' => 'schedule not found'], 400);
        }

        $movie = Movie::find($movie_id);

        if ($movie == null) {
            //return error 400
            return response()->json(['message' => 'movie not found'], 400);
        }

        $reservation_count = Reservation::where([['schedule_id', $request->schedule_id,], ['sheet_id', $request->sheetId]])->count();

        if ($reservation_count != 0) {

            //sheet.reserveformにリダイレクト
            // $movie_id = $reservations[0]->schedule->movie_id;
            // return redirect()->route('sheet.select', ['movie_id' => $movie_id, 'schedule_id' => $request->schedule_id])->with('message', 'その座席は既に予約済みです');
            return response()->json(['message' => 'その座席は既に予約済みです'], 400);
        }

        return view('reserveForm')->with(['schedule' => $schedule, 'movie' => $movie, 'sheet_id' => $request->sheetId, 'date' => $request->date]);
    }

    //
    public function reservestore(Request $request)
    {
        //座席予約フォーム登録エンドポイント
        //Request= schedule_id, sheet_id, name, email, date(screening_date)

        //バリデーション
        $validatedData = $request->validate([
            'schedule_id' => 'required',
            'sheet_id' => 'required',
            'name' => 'required',
            'email' => ['required', 'email'],
            'date' => ['required'],
        ]);

        //重複チェック
        //予約済みの座席を取得


        //予約済みの座席がある場合
        $reservations = Reservation::where([['schedule_id', $request->schedule_id,], ['sheet_id', $request->sheet_id]])->get();
        if ($reservations->count() != 0) {

            //sheet.reserveformにリダイレクト
            $movie_id = $reservations[0]->schedule->movie_id;
            return redirect()->route('sheet.reserveform', ['movie_id' => $movie_id, 'schedule_id' => $request->schedule_id,])->with('message', 'その座席は既に予約済みです');
        } else {

            //スケジュールIDは作品IDに紐づいている
            $schedule_id = $request->schedule_id;
            //座席ID
            $sheet_id = $request->sheet_id;
            //名前
            $name = $request->name;
            //メール
            $email = $request->email;
            //上映日
            $screening_date = $request->date;

            $reservation = new Reservation();
            $reservation->schedule_id = $schedule_id;
            $reservation->sheet_id = $sheet_id;
            $reservation->name = $name;
            $reservation->email = $email;
            //            $reservation->screening_date = $screening_date;
            $reservation->date = $screening_date;
            $result = $reservation->save();


            $movie_id = Schedule::where('id', $schedule_id)->first()->movie_id;

            //sheet.reserveformにリダイレクト
            if ($result == null) {
                //失敗時
                return redirect()->route('sheet.reserveform', ['movie_id' => $movie_id, 'schedule_id' => $schedule_id])->with('message', '予約に失敗しました。');
            } else {
                //成功時
                return redirect()->route('sheet.reserveform', ['movie_id' => $movie_id, 'schedule_id' => $schedule_id])->with('message', '予約が完了しました。');
            }
        }
    }
}
