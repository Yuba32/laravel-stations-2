<!DOCTYPE html>
<html lang="en">
<?php
$faker = new Faker\Generator();
$faker->addProvider(new Faker\Provider\Image($faker));
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movies</title>
</head>

<body>
  <ul>
    @foreach ($movies as $movie)
      <li>タイトル: {{$movie->title}}</li>
      <!-- <li><img src="{{$movie->image_url}}" alt=""></li> -->
      <li><img src="{{$faker->imageUrl()}}" alt=""></li>
    @endforeach
  </ul>

</body>

</html>