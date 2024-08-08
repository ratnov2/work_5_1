@component('box::components._box', [
    'alpine_data' => 'boxLimitData',
    'alpine_data_params' => $box_json,
])
    <x-slot name="icon">
        <i class="fas fa-box"></i>
    </x-slot>

    <x-slot name="title">
        <span x-text="box.name"></span>
    </x-slot>

    <x-slot name="image">
        <div class="h-full w-full" :style="`filter: hue-rotate(${box.hue_rotate ?? 0}deg); background: center / contain no-repeat url(${box.image})`"></div>
    </x-slot>

    <x-slot name="open_extra">
        <div class="w-full flex justify-center text-sm text-white">
            <span class="text-indigo-300" x-text="box.limit_left"></span>
        </div>
    </x-slot>
@endcomponent
