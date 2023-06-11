<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>映画作品詳細</title>
</head>

<body>
  <div>
    <table>
      <tr>
        <td>映画タイトル</td>
        <td>{{ $movie->title }}</td>
      </tr>
      <tr>
        <td>画像URL</td>
        <td>{{ $movie->image_url }}</td>
      </tr>
      <tr>
        <td>公開年</td>
        <td>{{ $movie->published_year }}</td>
      </tr>
      <tr>
        <td>上映中かどうか</td>
        <td>{{ $movie->is_showing }}</td>
      </tr>
      <tr>
        <td>概要</td>
        <td>{{ $movie->description }}</td>
      </tr>
      <tr>
        <td>登録日時</td>
        <td>{{ $movie->created_at }}</td>
      </tr>
      <tr>
        <td>更新日時</td>
        <td>{{ $movie->updated_at }}</td>
      </tr>
    </table>

  </div>
  <table>
    <th>
    <td>上映開始時刻</td>
    <td>上映終了時刻</td>
    </th>

    <tbody>
    @if ($schedules->isEmpty())
      <tr>
        <td colspan="2">上映スケジュールはありません</td>
      </tr>
    @else
      @foreach ($schedules as $schedule)
        <tr>
          <td>{{ $schedule->start_time->format('H:i') }}</td>
          <td>{{ $schedule->end_time->format('H:i') }}</td>
        </tr>
      @endforeach
    @endif
    </tbody>
  </table>


</body>

</html>
