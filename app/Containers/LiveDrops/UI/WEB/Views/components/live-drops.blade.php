<div x-data="liveDropsData()" class="flex flex-row-reverse w-full justify-end space-x-0.5 py-0.5 max-w-full overflow-hidden bg-gray-900 min-h-24 relative border-b border-gray-900">
    <template x-for="(live_drop, index) in live_drops" :key="index + '-' + live_drop.uid">
        <div class="group w-36 h-24 flex-shrink-0 relative flex items-center justify-center overflow-hidden">
            <span class="transition duration-300 opacity-0 group-hover:opacity-100 absolute z-30 w-full h-full bg-gray-800 flex flex-col space-y-1 items-center justify-center">
                <div class="transition-all duration-300 relative bg-contain bg-no-repeat w-12 h-12 rounded-lg border border-gray-700" :style="`background-image: url(${live_drop.player.image})`"></div>
                <span class="text-white text-sm whitespace-nowrap" x-text="live_drop.player.name"></span>
            </span>

            <span class="absolute z-20 top-1 right-2 text-xs text-gray-400">
                <i x-show="live_drop.type == 'jackpot'" class="fad fa-circle-notch"></i>
                <i x-show="live_drop.type == 'upgrade'" class="fad fa-chevron-double-up"></i>
                <i x-show="live_drop.type == 'box'" class="fad fa-box"></i>
            </span>

            @component('item::components.item-card', ['alpine__item' => 'live_drop.item'])@endcomponent
        </div>
    </template>

    <div x-ref="skeleton_live_drops">
        @include('livedrops::skeleton.live-drops')
    </div>
</div>
