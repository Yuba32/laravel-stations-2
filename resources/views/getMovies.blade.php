<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>映像作品リスト</title>
</head>

<body>
<div>
    <form method="GET" action="{{ route('movie.search') }}">
        @csrf

        <label for="is_showing">公開中:</label>
        <input type="radio" name="is_showing" value="">すべて
        <input type="radio" name="is_showing" value="1">公開中
        <input type="radio" name="is_showing" value="0">公開予定

        <label for="keyword">キーワード:</label>
        <input type="text" name="keyword" id="keyword"
               value="@if (isset($keyword)) {{ $keyword }} @endif">

        <input type="submit" value="検索">
    </form>
</div>

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
