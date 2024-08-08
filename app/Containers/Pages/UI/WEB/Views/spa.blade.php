<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:title" content="{{ $title }}">
        <meta name="description" content="{{ $keywords }}" />
        @production @if ($yandex_metrika) {!! $yandex_metrika !!} @endif @endproduction
        <link rel="shortcut icon" type="image/x-icon" href="{{ $favicon }}">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ mix('css/tailwind.css') }}">
        <title>{{ $title }}</title>
    </head>

    <body class="bg-gray-1000" ontouchstart>
        {{-- App --}}
        <div id="app" class="relative z-10 bg-gray-1000 bg-opacity-60 min-h-screen flex flex-col">
            {{-- Header --}}
            @include('pages::layouts.header')

            <div class="flex flex-col relative z-10 w-full h-full">
                {{-- Router view --}}
                <div x-data="routerView('main')" @hashchange.window="onHashChange()" class="w-full h-full py-2 px-2 lg:px-7">
                    <div class="w-full h-full"></div>
                    <template x-if="loading_route?.name == 'main.site'">@component('pages::pages.siteQuest.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.steamPayment'">@component('pages::pages.steamPayment.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.ban'">@component('pages::pages.ban.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.bonuses'">@component('pages::pages.bonuses.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.boxes'">@component('pages::pages.boxes.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.contests'">@component('pages::pages.contests.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.gameModes'">@component('pages::pages.gameModes.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.notifications'">@component('pages::pages.notifications.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.profile'">@component('pages::pages.profile.skeleton.index')@endcomponent</template>
                    <template x-if="loading_route?.name == 'main.refSystem'">@component('pages::pages.refSystem.skeleton.index')@endcomponent</template>
                </div>
            </div>

            {{-- Footer --}}
            @include('pages::layouts.footer')
        </div>

        {{-- Scripts --}}
        <script src="{{ mix('/js/app.js') }}"></script>

        {{-- Toasts --}}
        @include('pages::elements.toast')
    </body>
</html>
