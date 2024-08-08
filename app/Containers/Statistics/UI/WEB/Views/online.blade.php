<div>
    @component('statistics::item', ['icon' =>
        '
            <i class="fas fa-globe"></i>
            <span class="flex h-2 w-2 absolute bottom-0 right-0 rounded-full">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-300 border border-gray-800"></span>
            </span>
        ',
        'value' => '<span x-text="online"></span>',
        'desc' => 'онлайн'
    ]) @endcomponent
</div>
