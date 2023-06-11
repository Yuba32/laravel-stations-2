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

<div>
    <ul>
        @foreach ($movie_list as $movie)
            <li>タイトル: {{ $movie->title }} </li>
            <li><img src="{{ $movie->image_url }}" alt=""></li>
        @endforeach
    </ul>
</div>

<div class="mt-1 mb-1 row justify-content-center">
    {{ $movie_list->links() }}
</div>

</body>

</html>
