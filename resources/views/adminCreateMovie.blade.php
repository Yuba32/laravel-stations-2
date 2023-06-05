<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title></title>
</head>

<body>
  <form action="{{ url('/admin/movies/store') }}" method="POST">
    {{ csrf_field() }}

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
      <label for="title">映画タイトル:</label> <input type="text" name="title" id="title" required>
      <label for="image_url">画像URL:</label> <input type="url" name="image_url" id="image_url" required>
      <label for="is_showing">公開中:</label> <input type="checkbox" name="is_showing" id="is_showing">
      <label for="description">概要:</label>
      <textarea name="description" id="description"></textarea>
    </div>

    <div>
      <input type="submit" value="送信">
    </div>
  </form>


</body>

</html>
