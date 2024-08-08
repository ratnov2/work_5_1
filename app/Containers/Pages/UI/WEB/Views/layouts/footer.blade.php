<footer class="px-8 pt-16 mt-auto w-full bg-gray-900">
    <div class="grid gap-8 row-gap-6 mb-8 sm:grid-cols-3 lg:grid-cols-5">
        <div class="sm:col-span-2">
            @include('pages::elements.logo')
        </div>

        <div class="space-y-2 text-sm">
            <span class="text-base font-bold tracking-wide text-gray-300">Статистика</span>
            @if (!is_null($yandex_metrika_informer)) {!! $yandex_metrika_informer !!} @endif
        </div>

        <div class="space-y-2 text-sm">
            <span class="text-base font-bold tracking-wide text-gray-300">Соц. сети</span>
            @include('pages::layouts.menu.social')
        </div>

        <div class="flex justify-end items-center">
            <x-buttons.cooperation />
        </div>
    </div>

    <div class="text-gray-500 text-sm">
        {!! $footer !!}
    </div>

    <div class="flex flex-col-reverse justify-between pt-5 pb-10 border-t border-gray-800 lg:flex-row">
        <p class="text-sm text-gray-600">© Copyright 2022. All rights reserved.</p>
    </div>
</footer>
