<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{mix('css/tailwind.css')}}">
    <title>{{ $title }}</title>
</head>
    <body class="w-full h-screen bg-gray-1000 relative">
        <div class="w-full h-full flex flex-col justify-center items-center space-y-1 relative z-10">
            <div class="py-2 px-4 md:py-4 md:px-10 rounded-2xl bg-gray-900 flex flex-col items-center justify-center">
                <span class="text-white text-2xl md:text-5xl font-bold uppercase">{{ $title }}</span>
            </div>

            <p class="text-gray-100 text-md">{{ $desc }}</p>
        </div>

        <div class="fixed z-0 w-full h-full top-0 left-0 opacity-30" style="background: url({{ asset('img/pattern.jpg') }}); background-size: 50%;"></div>
    </body>
</html>
