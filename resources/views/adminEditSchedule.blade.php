<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>スケジュール編集画面</title>
</head>

<body>
<div class="alert aclert-danger">
    <ul>
        @if (session('message.error'))
        <li>{{ session('message.error') }}</li>
        @endif
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

<form action="{{ route('schedule.update', $movie->id) }}" method="POST">
    @method('PATCH')
    @csrf

    <fieldset>
        <div>

            <label for="start_time_date">開始日付:</label>
            <input type="text" name="start_time_date" id="start_time_date" value="{{ $schedule->start_time_date }}">
            <label for="start_time_time">開始時刻:</label>
            <input type="text" name="start_time_time" id="start_time_time" value="{{ $schedule->start_time_time }}">

            <label for="end_time_date">終了日付:</label>
            <input type="text" name="end_time_date" id="end_time_date" value="{{ $schedule->end_time_date }}">
            <label for="end_time_time">終了時刻:</label>
            <input type="text" name="end_time_time" id="end_time_time" value="{{ $schedule->end_time_time }}">

        </div>

        <div>
            <input type="submit" value="送信">
        </div>

    </fieldset>
</form>


</body>

</html>
