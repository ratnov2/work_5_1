@component('box::components._box', [
    'alpine_data' => 'boxPromocodeData',
    'alpine_data_params' => $box_json,
])
    <x-slot name="icon">
        <i class="fas fa-box"></i>
    </x-slot>

    <x-slot name="title">
        <span>Кейс за промокод</span>
    </x-slot>

    <x-slot name="image">
        <div class="h-full w-full" style="background: center / contain no-repeat url({{asset('img/promocase.v2.png')}})"></div>
    </x-slot>

    <x-slot name="open_extra">
        <input x-model="promocodeValue" class="input-default text-gray-300" type="text" placeholder="Введите промокод">
    </x-slot>

    <x-slot name="header">
        <div x-data="{ is_open: false }">
            <button @click="is_open = true" class="text-xs text-indigo-400">Где брать промокоды?</button>

            <x-modal is-open="is_open">
                <div class="text-white p-5 rounded-md bg-gray-800 w-full sm:w-fit">
                    Промокоды можно найти в наших соц. сетях:

                    @component('pages::layouts.menu.social', [
                        'youtube_link' => $settings_site->youtube_link,
                        'vk_link' => $settings_site->vk_link,
                        'telegram_link' => $settings_site->telegram_link,
                    ])@endcomponent
                </div>
            </x-modal>
        </div>
    </x-slot>
@endcomponent
