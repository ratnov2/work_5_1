<div class="space-y-10">
    <div class="flex flex-col w-full">
        <p class="text-xl text-white mb-2">Стандартные кейсы:</p>

        @if(!is_null($box_timer_json) || !is_null($box_promocode_json))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @if(!is_null($box_timer_json))
                    @component('boxunique::components.box-timer', ['box_json' => $box_timer_json])@endcomponent
                @endif

                @if(!is_null($box_promocode_json))
                    @component('boxunique::components.box-promocode', ['box_json' => $box_promocode_json, 'settings_site' => $settings_site])@endcomponent
                @endif
            </div>
        @else
            <x-banners.default class="rounded-md" title="Стандартные кейсы временно не доступны" desc="Возвращайтесь позже!" color="indigo" />
        @endif
    </div>

    <div class="flex flex-col w-full">
        <p class="text-xl text-white mb-2">Лимитированные кейсы:</p>

        @if(count($boxes_limit_json) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach ($boxes_limit_json as $box_json)
                    @include('boxlimit::components.box-limit')
                @endforeach
            </div>
        @else
            <x-banners.default class="rounded-md" title="Лимитированных кейсов не найдено" desc="Возвращайтесь позже!" color="indigo" />
        @endif
    </div>
</div>
