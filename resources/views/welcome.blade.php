<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

    </head>
    <body class="bg-gray">
        @foreach ($repositories as $repo)
            <h2>{{$repo->url}}</h2>
            <p>{{$repo->description}}</p>
        @endforeach
    </body>
</html>
