@component('box::components._box', [
    'alpine_data' => 'boxTimerData',
    'alpine_data_params' => $box_json,
])
    <x-slot name="icon">
        <i class="fad fa-clock"></i>
    </x-slot>

    <x-slot name="title">
        <span>Кейс по таймеру</span>
    </x-slot>

    <x-slot name="image">
        <div class="h-full w-full" style="background: center / contain no-repeat url({{asset('img/timercase.v2.png')}})"></div>
    </x-slot>

    <x-slot name="open_extra">
        <div x-data="timerData(timerDropExpiry)" class="flex justify-center" @start-box-timer.window="start($event.detail.timerDropExpiry)">
            <span class="inline-flex items-center space-x-2 text-gray-50">
                <span x-text="time.days"></span>
                <span>:</span>
                <span x-text="time.hours"></span>
                <span>:</span>
                <span x-text="time.minutes"></span>
                <span>:</span>
                <span x-text="time.seconds"></span>
            </span>
        </div>
    </x-slot>
@endcomponent
