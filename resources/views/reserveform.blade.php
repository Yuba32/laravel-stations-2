<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>予約フォーム</title>
</head>

<body>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

<form action="{{route('sheet.reservestore')}}" method="POST">
    @csrf

    <div>

        <label for="movie_id">作品ID:{{$movie->id}}</label>
        <input type="hidden" name="movie_id" id="movie_id" value="{{$movie->id}}">

        <label for="schedule_id">上映スケジュールID:{{$schedule->id}}</label>
        <input type="hidden" name="schedule_id" id="schedule_id" value="{{$schedule->id}}">

        <label for="sheet_id">座席ID:{{$sheet_id}}</label>
        <input type="hidden" name="sheet_id" id="sheet_id">

        <label for="date">日付:{{$date}}</label>
        <input type="text" name="date" id="date" value="{{$date}}">

        <label for="name">予約者氏名:</label>
        <input type="text" name="name" id="name">

        <label for="email">予約者メールアドレス:</label>
        <input type="email" name="email" id="email">

    </div>

</form>
