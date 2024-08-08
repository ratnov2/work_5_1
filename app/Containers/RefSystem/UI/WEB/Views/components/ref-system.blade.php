<div x-data="refSystemData()" class="min-h-[400px] grid grid-cols-1 lg:grid-cols-3 gap-2 items-start">
    <div class="h-full col-span-1 lg:col-span-2 grid gap-2 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <div class="col-span-1 md:col-span-1 lg:col-span-1 flex flex-col items-center justify-center p-5 space-y-2 rounded-lg bg-gray-900">
            <span class="uppercase text-white">Ваш уровень</span>
            {{-- Custom --}}
            @if($player->ref_level->type == 'custom')
                @component('refsystem::elements.progress-circle', ['precent' => 100, 'level' => '<i class="fas fa-user"></i>' ])@endcomponent
                <div class="flex flex-col space-y-2 items-center">
                    <span class="text-white uppercase text-center">{{$player->ref_level->name}}</span>
                </div>
            {{-- Standart --}}
            @else
                @if ($player->next_ref_level()->level == $player->ref_level->level)
                    @component('refsystem::elements.progress-circle', ['precent' => 100, 'level' => $player->ref_level->level])@endcomponent
                @else
                    @component('refsystem::elements.progress-circle', ['precent' => round($sum_payments_referrals * 100 / $player->next_ref_level()->sum_payments), 'level' => $player->ref_level->level])@endcomponent
                @endif

                <div class="flex flex-col space-y-2 items-center">
                    @if ($player->next_ref_level()->level == $player->ref_level->level)
                        <span class="text-white text-xs uppercase text-center">Макс. уровень</span>
                    @else
                        <div class="flex items-center space-x-2 text-green-300 text-lg">
                            <span><i class="fas fa-coin"></i> {{$sum_payments_referrals}}</span>
                            <span class="opacity-50">/</span>
                            <span class="opacity-50">{{$player->next_ref_level()->sum_payments}}</span>
                        </div>
                        <span class="text-white text-sm uppercase">до {{$player->next_ref_level()->level}} уровня</span>
                    @endif
                </div>
            @endif
        </div>

        <div class="col-span-1 md:col-span-1 lg:col-span-2 flex flex-col w-full">
            <div class="flex flex-col p-3 mb-2 rounded-lg bg-gray-900 space-y-2">
                <div class="flex text-white items-center">
                    <h5 class="text-white text-sm bg-gray-800 bg-opacity-90 h-full rounded-tl-lg rounded-bl-lg px-2 py-1 whitespace-nowrap w-20 inline-flex items-center justify-center flex-shrink-0">Ваш код</h5>

                    <input type="text" x-model="ref_code" class="focus:outline-none focus:ring-2 focus:ring-green-400 h-full w-full text-sm form-control bg-gray-800 rounded-tr-md rounded-br-md px-3">

                    <span class="w-14 h-7 inline-flex flex-shrink-0">
                        <x-buttons.actionable @click="setRefCode()"
                            size="small"
                            color="green"
                            class="ml-2"
                            is-acting="is_setting_ref_code"
                            action='<i class="ml-0.5 fas fa-edit"></i>'
                        />
                    </span>
                </div>

                <div class="flex text-white items-center" x-data="{ ref_link: '{{request()->root() . '/?ref=' . $player->ref_code}}' }">
                    <h5 class="text-white text-sm bg-gray-800 bg-opacity-90 h-full rounded-tl-md rounded-bl-md px-2 py-1 w-20 inline-flex items-center justify-center flex-shrink-0">Ссылка</h5>

                    <input x-model="ref_link" name="ref_link" id="ref_link" type="text" class="focus:outline-none focus:ring-2 focus:ring-green-400 h-full w-full text-sm form-control bg-gray-800 rounded-tr-md rounded-br-md px-3" readonly>

                    <span class="w-14 h-7 inline-flex flex-shrink-0">
                        <x-buttons.default @click="copyToClipboard(ref_link)"
                            color="green"
                            size="small"
                            class="ml-2"
                        >
                            <i class="fas fa-copy"></i>
                        </x-buttons.default>
                    </span>
                </div>
            </div>

            <div class="flex flex-col p-3 rounded-md bg-gray-900 h-full space-y-3">
                <div class="flex justify-start border-b border-gray-700">
                    <span class="text-md text-white">Статистика</span>
                </div>

                <p class="text-xs text-gray-300">За каждого приглашенного человека вы получаете бонус</p>

                <div class="w-full h-full rounded-lg flex items-start justify-center space-x-2 flex-grow-1">
                    <div class="flex flex-col items-center justify-center rounded-lg p-2 bg-gray-800 flex-shrink-0">
                        <span class="text-indigo-400 text-xl"><i class="fas fa-users"></i></span>
                        <span class="text-xl text-white">{{$player->referrals->count()}}</span>
                        <span class="text-md text-gray-500 text-xs">Приглашено</span>
                    </div>

                    <div class="flex flex-col items-center justify-center rounded-lg p-2 bg-gray-800 flex-shrink-0">
                        <span class="text-green-300 text-xl"><i class="fas fa-gift"></i></span>
                        <span class="text-xl text-white">{{$player->ref_level->bonus_precent}} %</span>
                        <span class="text-md text-gray-500 text-xs">Бонус</span>
                    </div>

                    <div class="flex flex-col text-white items-start flex-grow">
                        <h5 class="text-white text-md md:text-xl">БОНУСНЫЙ БАЛАНС</h5>
                        <div class="flex items-center space-x-2" x-data="{is_open: false}">
                            <input type="number" step="0.01" readonly :value="$store.player.player.ref_balance" class="h-8 focus:outline-none focus:ring-2 focus:ring-green-400 w-full text-sm form-control bg-gray-800 rounded-md rounded-br-lg px-2 py-1">

                            <x-buttons.default @click="is_open = true" color="green" size="small" class="w-8 h-8 flex-shrink-0">
                                <i class="far fa-sync"></i>
                            </x-buttons.default>

                            <x-modal is-open="is_open">
                                <div class="rounded-md bg-gray-800 p-3 w-full">
                                    <div class="flex flex-wrap sm:flex-nowrap w-full justify-center items-center space-y-2 sm:space-y-0 space-x-0 sm:space-x-2 py-1">
                                        <div class="w-full sm:w-auto flex">
                                            <div class="text-sm p-3 rounded-tl-md rounded-bl-md text-green-300 border-t-2 border-l-2 border-b-2 border-green-400 bg-gray-700">
                                                <x-icons.currency />
                                            </div>
                                            <input x-model="ref_balance_sum" type="number" step="0.01" class="w-full sm:w-auto border-t-2 border-r-2 border-b-2 border-green-400 focus:outline-none rounded-tr-md rounded-br-md focus:border-green-400 text-green-300 p-3 bg-gray-800 text-sm">
                                        </div>

                                        <x-buttons.actionable @click="makeRefBalanceWithdraw()"
                                            color="green"
                                            is-acting="is_ref_balance_withdrawing"
                                            action='Вывести'
                                        />
                                    </div>
                                </div>
                            </x-modal>
                        </div>
                        <p class="text-xs text-gray-600">Вывод доступен от 50 <i class="fas fa-coin"></i></p>
                    </div>
                </div>

                <div class="w-full h-full rounded-lg flex items-center justify-center space-x-2 flex-grow-1">
                    <div class="rounded-lg p-3 bg-gray-800 w-full">
                        <p class="text-xs text-gray-300 ">Внимание! Условия получения бонуса:</p>

                        <ul class="text-xs text-green-300">
                            <li> - Уровень аккаунта Steam реферала больше 3-го</li>
                            <li> - Вы получаете бонус после пополнения счета вашим рефералом</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="h-full col-span-1 flex flex-col bg-gray-900 p-3 rounded-lg items-center space-y-5">
        <div class="flex items-center justify-between space-x-2 w-full px-3 py-2 rounded">
            <span class="uppercase text-white text-md">Уровни</span>
        </div>

        @if($player->ref_level->type == 'custom')
            @component('refsystem::elements.ref-custom-level-li', ['ref_level' => $player->ref_level])@endcomponent
        @endif
        <div class="flex flex-col items-center justify-center w-full space-y-5">
            <div class="w-full flex items-center flex-nowrap justify-between space-x-1 text-gray-500 px-2">
                <div class="w-1/4 flex justify-start">
                    <span class="whitespace-nowrap text-xs">LVL</span>
                </div>
                <div class="w-1/4 flex justify-center">
                    <span class="whitespace-nowrap text-xs">Депозитов</span>
                </div>
                <div class="w-1/4 flex justify-end">
                    <span class="whitespace-nowrap text-xs">Ваш бонус</span>
                </div>
                <div class="w-1/4 flex justify-end">
                    <span class="whitespace-nowrap text-xs">Реф. бонус</span>
                </div>
            </div>

            <div class="flex flex-col w-full space-y-2">
                @foreach ($ref_levels as $ref_level)
                    <div class="{{$player->ref_level->id == $ref_level->id ? '' : 'opacity-30'}}">
                        @component('refsystem::elements.ref-level-li', ['ref_level' => $ref_level])@endcomponent
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

