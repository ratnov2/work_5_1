<div class="my-3 bg-white p-4 rounded-lg space-y-10 shadow-lg">
    <div class="flex flex-col space-y-2">
        <h2 class="font-bold text-2xl">Ответ игрока (проверка для старта)</h2>
        @include('orchid.playerSiteQuest.player-wait-answer', ['wait_answer' => $player_site_quest->wait_work_answer])
    </div>

    <div class="flex flex-col space-y-2">
        <h2 class="font-bold text-2xl">Ответ игрока (проверка для выдачи награды)</h2>
        @include('orchid.playerSiteQuest.player-wait-answer', ['wait_answer' => $player_site_quest->wait_done_answer])
    </div>
</div>