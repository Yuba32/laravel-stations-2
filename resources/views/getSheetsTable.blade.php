<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>座席表</title>
</head>

<body>
<div>

    {{--
    | - | - | スクリーン | - | - |
    | a-1 | a-2 | a-3 | a-4 | a-5 |
    | b-1 | b-2 | b-3 | b-4 | b-5 |
    | c-1 | c-2 | c-3 | c-4 | c-5 |
    --}}
    <div>
        <table>
            <thead>
            <th>-</th>
            <th>-</th>
            <th>スクリーン</th>
            <th>-</th>
            <th>-</th>
            </thead>
            <tbody>
            @for ($i = 0; $i < $rows; $i++)
                <tr>
                    @for ($j = 1; $j <= $columns; $j++)
                        <td>{{ $alphabet[$i] }}-{{ $j }}</td>
                    @endfor
                </tr>
            @endfor
            </tbody>
        </table>
    </div>


</body>

</html>
