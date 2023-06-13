<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>スケジュール詳細</title>
    <script>
        var del = function (id) {
            var result = confirm('削除しますか?');

            if (result) {
                var url = '/admin/schedules/' + id + '/destroy';
                var param = {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                }

                fetch(url, param).then(function (response) {
                    location.reload();
                })
            }
        }
    </script>
</head>

<body>
<div>
    <div>
        <ul>
            <li>
                <ul>
                    <li>スケジュールID : {{$schedule->id}}</li>
                    {{--                    <li>映画ID: {{$movie->id}} </li>--}}
                    {{--                    <li>タイトル: {{$movie->title}}</li>--}}
                    <li>開始時刻 : {{$schedule->start_time->format('H:i')}}</li>
                    <li>終了時刻 : {{$schedule->end_time->format('H:i')}}</li>
                    {{--link to getschedulebyid--}}
                    <input type="button" value="削除" onclick="del({{$schedule->id}})">
                </ul>
            </li>
        </ul>
    </div>
</div>


</body>

</html>
