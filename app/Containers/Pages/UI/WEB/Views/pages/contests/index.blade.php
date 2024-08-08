<div class="grid grid-cols-1 xl:grid-cols-3 gap-2">
    <div class="col-span-2 flex flex-col space-y-2 overflow-y-auto">
        <p class="text-xl text-white">Список активных конкурсов:</p>

        @if(count($contests_jsons) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2">
                @foreach ($contests_jsons as $contest_json)
                    @include('contest::components.contest')
                @endforeach
            </div>
        @else
            <x-banners.default class="rounded-md" title="Активных розыгрышей не найдено" desc="В ближайшее время мы активируем новые розыгрыши, возвращайтесь!" color="indigo" />
        @endif
    </div>

    <div class="col-span-1 flex flex-col space-y-2 overflow-y-auto">
        <p class="text-xl text-white">Последние 3 розыгрыша:</p>

        @if(count($history_contests_jsons) > 0)
            <div class="grid grid-cols-1 gap-2">
                @foreach ($history_contests_jsons as $history_contest_json)
                    @include('contest::components.history-contest')
                @endforeach
            </div>
        @else
            <x-banners.default class="rounded-md" title="Завершенных розыгрышей не найдено" color="indigo" />
        @endif
    </div>
</div>
