<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>スケジュール一覧</title>
</head>

<body>


@foreach ($movies as $movie)
    {{--    @if ($movie->schedules()->count() != 0)--}}
    <div>
        <h2>ID: {{$movie->id}} タイトル: {{$movie->title}}</h2>
        <div>
            <ul>
                <li>
                    @foreach($movie->schedules as $schedule)
                        <ul>
                            {{--link to getschedulebyid--}}
                            <li><a href="{{route('schedule.getbyid', ['id' => $schedule->id])}}"> ID
                                    : {{$schedule->id}}</a></li>
                            <li>開始時刻 : {{$schedule->start_time->format('H:i')}}</li>
                            <li>終了時刻 : {{$schedule->end_time->format('H:i')}}</li>
                        </ul>
                    @endforeach
                </li>
            </ul>
        </div>
    </div>
    {{--    @endif--}}
@endforeach

</body>

</html>
