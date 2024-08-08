<div class="flex justify-end flex-grow h-full space-x-0.5 relative">
    @component('jackpot::round.statistics.item', ['title' => 'Игроков', 'icon' => '<i class="fas fa-users"></i>'])
        <span x-text="{{$alpine__count_players}}"></span>
    @endcomponent
    @component('jackpot::round.statistics.item', ['title' => 'Скинов', 'icon' => '<i class="fas fa-swords"></i>'])
        <span x-text="{{$alpine__count_items}}"></span>
    @endcomponent
    @component('jackpot::round.statistics.item', ['title' => 'Общий банк', 'icon' => '<i class="fas fa-coin"></i>'])
        <span x-text="{{$alpine__bank}}"></span>
    @endcomponent
    <span class="w-20 h-full absolute z-20 bg-gradient-to-l from-gray-900 top-0 -left-20"></span>
</div>
