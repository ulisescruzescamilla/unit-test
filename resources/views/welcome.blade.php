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
        <ul class="max-w-lg bg-white border-r border-gray-300 shadow-xl">
            @foreach ($repositories as $repo)
                <li class="flex items-center text-black p-2 hover:bg-ray-300">
                    <img class="{{$repository->user->profile_photo_url}}" class="w-12 h-12 rounded-full mr-2">
                </li>

                <div class="flex justify-bewteen w-full">
                    <div class="flex-1">
                        <h2 class="text-sm font-semibold text-black">{{$repo->url}}</h2>
                        <p>{{$repo->description}}</p>
                    </div>
                    <span class="text-xs font-medium text-gray-600">{{$repo->created_at}}</span>
                </div>
            @endforeach
        </ul>
    </body>
</html>
