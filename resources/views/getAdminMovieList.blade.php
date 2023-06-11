<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>管理画面 - 一覧</title>
    <script>
        var del = function (id) {
            var result = confirm('削除しますか?');

            if (result) {
                var url = '/admin/movies/' + id + '/destroy';
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
<div>
    <table>
        <thead>
        <tr>
            <td>ID</td>
            <td>映画タイトル</td>
            <td>画像URL</td>
            <td>公開年</td>
            <td>上映中かどうか</td>
            <td>概要</td>
            <td>登録日時</td>
            <td>更新日時</td>
            <td>編集</td>
            <td>削除</td>
        </tr>
        </thead>

        <tbody>
        @foreach ($movies as $movie)
            <tr>
                <td>
                    {{ $movie->id }}
                </td>
                <td>
                    {{ $movie->title }}
                </td>
                <td>
                    {{ $movie->image_url }}
                </td>
                <td>
                    {{ $movie->published_year }}
                </td>
                <td>
                    @if ($movie->is_showing)
                        上映中
                    @else
                        上映予定
                    @endif
                </td>
                <td>
                    {{ $movie->description }}
                </td>
                <td>
                    {{ $movie->created_at }}
                </td>
                <td>
                    {{ $movie->updated_at }}
                </td>
                <td>
                    <a href="{{ route('movie.edit', $movie->id) }}">編集</a>
                </td>
                <td>
                    <input type="button" value="削除" onclick="del({{ $movie->id }}) ">
                </td>
            </tr>

            {{-- <li><img src="{{ $movie->image_url }}" alt=""></li> --}}
        @endforeach
        </tbody>
    </table>
</div>

</body>

</html>
