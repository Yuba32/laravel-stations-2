<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>作成</title>
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
<form action="{{ url('/admin/movies/store') }}" method="POST">
    @csrf

    <fieldset>
        <div>

            <label for="title">映画タイトル:</label>
            <input type="text" name="title" id="title" required>

            <label for="image_url">画像URL:</label>
            <input type="url" name="image_url" id="image_url" required>

            <label for="published_year">公開年:</label>
            <input type="text" name="published_year" id="published_year">

            <label for="is_showing">公開中:</label>
            <input type="checkbox" name="is_showing" id="is_showing" value="1">
            <input type="hidden" name="is_showing" value="0">

            <label for="description">概要:</label>
            <textarea name="description" id="description"></textarea>

            <label for="genre">ジャンル:</label>
            <input type="text" name="genre" id="genre" required>

        </div>

        <div>
            <input type="submit" value="送信">
        </div>
    </fieldset>
</form>


</body>

</html>
