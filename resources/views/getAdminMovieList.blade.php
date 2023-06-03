<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>管理画面 - 一覧</title>
</head>

<body>
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
      </tr>
    </thead>

    <tbody>
      @foreach ($movies as $movie)
        <tr>
          {{ $movie->id }}
        </tr>
        <tr>
          {{ $movie->title }}
        </tr>
        <tr>
          {{ $movie->image_url }}
        </tr>
        <tr>
          {{ $movie->published_year }}
        </tr>
        <tr>
          @if ($movie->is_showing)
            上映中
          @else
            上映予定
          @endif
        </tr>
        <tr>
          {{ $movie->description }}
        </tr>
        <tr>
          {{ $movie->created_at }}
        </tr>
        <tr>
          {{ $movie->updated_at }}
        </tr>

        {{-- <li><img src="{{ $movie->image_url }}" alt=""></li> --}}
      @endforeach
    </tbody>
  </table>

</body>

</html>
