<div class="flex flex-col space-y-2">
    <div class="relative rounded-md flex items-center justify-center flex-wrap sm:flex-nowrap sm:justify-between bg-gray-900 p-10">
        <div class="w-full sm:w-max flex flex-col px-4">
            <span class="text-gray-50 text-2xl font-bold uppercase">
                ТОП ИГРОКОВ
                <span class="relative group inline-flex justify-center">
                    <i class="fad fa-info-circle"></i>
                    <div class="w-44 opacity-100 group-hover:visible normal-case invisible absolute top-full z-30 space-y-1 bg-gray-900 text-gray-50 rounded px-4 py-2 shadow-md text-xs">
                        <p>Раз в {{$top_contest_settings->every_hours}} час(-а) мы проводим розыгрыш скинов среди тех, кто больше всех поставил в игровых режимах. Просто ставьте в разных игровых режимах и поднимайтесь в топе!</p>
                    </div>
                </span>
            </span>
            <p class="text-gray-300 text-xs">Играйте в режимы, поднимайтесь в топе и выигрывайте скины</p>
        </div>
        <div class="w-full sm:w-max h-full flex flex-col items-center justify-center p-0 xl:p-2">
            <div class="flex items-center text-4xl sm:text-3xl font-bold space-x-1 text-orange-300" x-data="timerData({{$next_start_date}})">
                <span x-text="time.days"></span>
                <span>:</span>
                <span x-text="time.hours"></span>
                <span>:</span>
                <span x-text="time.minutes"></span>
                <span>:</span>
                <span x-text="time.seconds"></span>
            </div>
            <span class="text-gray-300 uppercase text-md sm:text-xs">осталось до раздачи скинов</span>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-2 items-start">
        @foreach ($top_contest_players as $top_contest_player)
            @if($top_contest_player['type'] == 'top')
                @component('topcontest::top-place-card', [
                    'top_contest_player' => $top_contest_player
                ])@endcomponent
            @else
                @component('topcontest::place-card', [
                    'top_contest_player' => $top_contest_player
                ])@endcomponent
            @endif
        @endforeach
    </div>
</div>
