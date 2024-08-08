<div>
    <template x-if="$store.player.player != null">
        <div class="w-full flex items-center justify-center space-x-3">
            <div x-data="{is_open: false}">
                <button class="rounded bg-green-400 py-0.5 px-3" @click="is_open = true">
                    <span class="text-black text-xl opacity-70">
                        <i class="fas fa-wallet"></i>
                    </span>
                </button>

                <x-modal is-open="is_open">
                    @include('paymentsection.payment::components.payment-window')
                </x-modal>
            </div>

            <div class="flex flex-col">
                <a href="#/profile" class="flex space-x-2 items-center">
                    <div class="relative bg-contain bg-no-repeat w-10 h-10 rounded-lg" :style="'background-image: url(' + $store.player.player.image +')'"></div>

                    <div class="flex flex-col items-start">
                        <span class="text-sm text-gray-200" x-text="$store.player.player.name"></span>
                        <span class="text-green-300 text-sm"> <span x-text="$store.player.player.balance"></span> <i class="fas fa-coin"></i></span>
                    </div>
                </a>
            </div>

            <a href="{{route('logout')}}" class="text-gray-700"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </template>

    <template x-if="$store.player.player == null">
        <a class="whitespace-nowrap uppercase text-xl text-gray-200" href="{{route('auth.steam')}}"><i class="fab fa-steam"></i> <span class="font-bold">Авторизация</span></a>
    </template>
</div>
