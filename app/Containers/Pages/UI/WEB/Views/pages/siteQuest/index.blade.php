<div x-data="siteData({{$site_json}}, {{!is_null($player_site_quests_json) ? $player_site_quests_json : 'null'}})" 
    @updated-player-site-quest="onUpdatedPlayerSiteQuest(event.detail)" 
    class="lg:mx-auto lg:container text-gray-50 body-font overflow-hidden grid grid-cols-1 lg:grid-cols-4 gap-5"
>
    <div class="col-span-1 lg:col-span-1 w-full">
        <div class="shadow-md rounded-xl group p-2 bg-gray-900 flex flex-col items-center justify-between relative space-y-2">
            @if ($site->vpn == 1 || $site->new == 1 || $site->hot == 1)
                <div class="w-full flex space-x-2 font-bold justify-end">
                    @if($site->new == 1) <span class="py-0.5 px-1.5 rounded-md bg-gray-1000 text-indigo-300">NEW</span> @endif
                    @if($site->hot == 1) <span class="py-0.5 px-1.5 rounded-md bg-gray-1000 text-red-300">HOT</span> @endif
                    @if($site->vpn == 1) <span class="py-0.5 px-1.5 rounded-md bg-gray-1000 text-green-300">VPN</span> @endif
                </div>
            @endif
        
            <div class="w-full p-4 flex-col items-center justify-center mt-auto space-y-2">
                <img class="w-full" src="{{$site->image}}" alt="">
        
                <div class="w-full flex flex-col mt-auto space-y-2">
                    <a href="{{$site->link}}" target="_blank">
                        <x-buttons.default color="green">
                            Выполнить задание
                        </x-buttons.default>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-span-1 lg:col-span-3 space-y-10">
        {{-- Новые задания --}}
        <div class="w-full">
            <h2 class="text-sm title-font text-gray-500 tracking-widest">задания</h2>

            <h1 class="text-white text-3xl title-font font-medium mb-1">Новые задания</h1>
    
            <x-accordion>
                <template x-for="(site_quest, index) in newSiteQuests" :key="`site_quest_${site_quest.id}`">
                    <div x-data="siteQuestData(site_quest)">
                        <x-accordion-item index="index" title="site_quest.name">
                            <div class="flex flex-col space-y-4">
                                @include('pages::pages.siteQuest.elements.site-quest-info', ['site_quest' => 'site_quest'])
        
                                <template x-if="$store.player.player != null">
                                    <form x-ref="takeQuestForm" class="space-y-3" @submit="takeQuest(event)">
                                        <input type="hidden" name="site_quest_id" :value="site_quest.id" />
        
                                        {{-- Input text --}}
                                        <template x-if="site_quest.is_wait_work_answer_required == true">
                                            @include('pages::pages.siteQuest.elements.site-quest-player-info')
                                        </template>

                                        {{-- Not done --}}
                                        <div class="flex justify-start">
                                            {{-- New --}}
                                            <x-buttons.actionable type="submit" class="w-auto"
                                                color="green"
                                                is-acting="is_taking_quest"
                                                action='Взять задание'
                                            />
                                        </div>
                                    </form>
                                </template>
        
                                <template x-if="$store.player.player == null">
                                    <x-banners.auth class="rounded" />
                                </template>
                            </div>
                        </x-accordion-item>
                    </div>
                </template>
            </x-accordion>

            <template x-if="newSiteQuests.length == 0">
                <x-banners.default color="indigo" class="rounded" title="Заданий не найдено" />
            </template>
        </div>

        {{-- Задания, ждущие информации для взятия --}}
        <template x-if="playerSiteQuestsInStart.length != 0">
            <div class="w-full">
                <h1 class="text-white text-3xl title-font font-medium mb-1">Требуется доработка</h1>
        
                <x-accordion>
                    <template x-for="(player_site_quest, index) in playerSiteQuestsInStart" :key="`player_site_quest_in_working_${player_site_quest.id}`">
                        <div x-data="siteQuestData(player_site_quest.site_quest)">
                            <x-accordion-item index="index" title="player_site_quest.site_quest.name">
                                <div class="flex flex-col space-y-4">
                                    @include('pages::pages.siteQuest.elements.site-quest-info', ['site_quest' => 'player_site_quest.site_quest'])

                                    <div x-show="player_site_quest.wait_work_comment" class="flex items-start space-x-2">
                                        <label>Комментарий администратора:</label>

                                        <p x-text="player_site_quest.wait_work_comment"></p>
                                    </div>
            
                                    <form x-ref="checkInStartSiteQuest" class="space-y-3" @submit="checkInStartSiteQuest(event)">
                                        <input type="hidden" name="site_quest_id" :value="player_site_quest.site_quest.id" />
        
                                        {{-- Input text --}}
                                        <template x-if="player_site_quest.site_quest.is_wait_done_answer_required == true">
                                            @include('pages::pages.siteQuest.elements.site-quest-player-info', ["site_quest_id" => "player_site_quest.site_quest.id"])
                                        </template>
        
                                        <div class="flex justify-start">
                                            {{-- New --}}
                                            <x-buttons.actionable type="submit" class="w-auto"
                                                color="green"
                                                is-acting="is_checking_quest"
                                                action='На проверку'
                                            />
                                        </div>
                                    </form>
                                </div>
                            </x-accordion-item>
                        </div>
                    </template>
                </x-accordion>
            </div>
        </template>

        {{-- Задания, ждущие одобрения для взятия --}}
        <template x-if="playerSiteQuestsWaitWork.length != 0">
            <div class="w-full">
                <h1 class="text-white text-3xl title-font font-medium mb-1">Проверка условий для начала задания</h1>
        
                <x-accordion>
                    <template x-for="(player_site_quest, index) in playerSiteQuestsWaitWork" :key="`player_site_quest_in_working_${player_site_quest.id}`">
                        <div x-data="siteQuestData(player_site_quest.site_quest)">
                            <x-accordion-item index="index" title="player_site_quest.site_quest.name">
                                <div class="flex flex-col space-y-4">
                                    @include('pages::pages.siteQuest.elements.site-quest-info', ['site_quest' => 'player_site_quest.site_quest'])
            
                                    <x-banners.default color="indigo" class="rounded" title="Ожидает подтверждения" desc="После проверки, данное задание будет доступно для выполнения" />
                                </div>
                            </x-accordion-item>
                        </div>
                    </template>
                </x-accordion>
            </div>
        </template>
        
        {{-- Задания, ждущие информации для награды --}}
        <template x-if="playerSiteQuestsInWorking.length != 0">
            <div class="w-full">
                <h1 class="text-white text-3xl title-font font-medium mb-1">В работе</h1>
        
                <x-accordion>
                    <template x-for="(player_site_quest, index) in playerSiteQuestsInWorking" :key="`player_site_quest_wait_work_${player_site_quest.id}`">
                        <div x-data="siteQuestData(player_site_quest.site_quest)">
                            <x-accordion-item index="index" title="player_site_quest.site_quest.name">
                                <div class="flex flex-col space-y-4">
                                    @include('pages::pages.siteQuest.elements.site-quest-info', ['site_quest' => 'player_site_quest.site_quest'])

                                    <div x-show="player_site_quest.wait_done_comment" class="flex flex-col space-y-1">
                                        <label>Комментарий администратора:</label>

                                        <p x-text="player_site_quest.wait_done_comment"></p>
                                    </div>
            
                                    <form x-ref="checkInWorkingSiteQuest" class="space-y-3" @submit="checkInWorkingSiteQuest(event)">
                                        <input type="hidden" name="site_quest_id" :value="player_site_quest.site_quest.id" />
        
                                        {{-- Input text --}}
                                        <template x-if="player_site_quest.site_quest.is_wait_done_answer_required == true">
                                            @include('pages::pages.siteQuest.elements.site-quest-player-info')
                                        </template>
        
                                        <div class="flex justify-start">
                                            {{-- New --}}
                                            <x-buttons.actionable type="submit" class="w-auto"
                                                color="green"
                                                is-acting="is_checking_quest"
                                                action='На проверку'
                                            />
                                        </div>
                                    </form>
                                </div>
                            </x-accordion-item>
                        </div>
                    </template>
                </x-accordion>
            </div>
        </template>

        {{-- Задания, ждущие одобрения для награды --}}
        <template x-if="playerSiteQuestsWaitDone.length != 0">
            <div class="w-full">
                <h1 class="text-white text-3xl title-font font-medium mb-1">Проверка выполнения задания</h1>
        
                <x-accordion>
                    <template x-for="(player_site_quest, index) in playerSiteQuestsWaitDone" :key="`player_site_quest_wait_done_${player_site_quest.id}`">
                        <div x-data="siteQuestData(player_site_quest.site_quest)">
                            <x-accordion-item index="index" title="player_site_quest.site_quest.name">
                                <div class="flex flex-col space-y-4">
                                    @include('pages::pages.siteQuest.elements.site-quest-info', ['site_quest' => 'player_site_quest.site_quest'])
            
                                    <x-banners.default color="indigo" class="rounded" title="Ожидает подтверждения" desc="После проверки, данное задание будет доступно для выполнения" />
                                </div>
                            </x-accordion-item>
                        </div>
                    </template>
                </x-accordion>
            </div>
        </template>

        {{-- Список выполненных заданий --}}
        <div class="w-full">
            <h1 class="text-white text-3xl title-font font-medium mb-1">Выполненные задания</h1>
    
            <x-accordion>
                <template x-for="(player_site_quest, index) in playerSiteQuestsDone" :key="`player_site_quest_done_${player_site_quest.id}`">
                    <div x-data="siteQuestData(player_site_quest.site_quest)">
                        <x-accordion-item index="index" title="player_site_quest.site_quest.name">
                            <div class="flex flex-col space-y-4">
                                @include('pages::pages.siteQuest.elements.site-quest-info', ['site_quest' => 'player_site_quest.site_quest'])
        
                                <x-banners.default color="green" class="rounded" title="Задание выполнено">
                                    <x-slot name="desc">
                                        <div class="flex flex-col">
                                            <span>Получено:</span>
                                            <template x-for="reward in player_site_quest.rewards" :key="reward.id">
                                                <span class="inline-flex space-x-1">
                                                    <span x-text="reward.value"></span> 
                                                    <x-icons.currency />
                                                </span>
                                            </template>
                                        </div>
                                    </x-slot>
                                </x-banners.default>

                                <template x-if="player_site_quest.site_quest.is_reusable">
                                    <form x-ref="takeQuestForm" class="space-y-3" @submit="takeQuest(event)">
                                        <label for="">Повтор задания:</label>

                                        <input type="hidden" name="site_quest_id" :value="site_quest.id" />
        
                                        <template x-if="site_quest.is_wait_work_answer_required == true">
                                            @include('pages::pages.siteQuest.elements.site-quest-player-info')
                                        </template>

                                        <div class="flex justify-start">
                                            {{-- New --}}
                                            <x-buttons.actionable type="submit" class="w-auto"
                                                color="indigo"
                                                is-acting="is_taking_quest"
                                                action='Взять задание еще раз'
                                            />
                                        </div>
                                    </form>
                                </template>
                            </div>
                        </x-accordion-item>
                    </div>
                </template>
            </x-accordion>

            <template x-if="playerSiteQuestsDone.length == 0">
                <x-banners.default color="indigo" class="rounded" title="Заданий не найдено" />
            </template>
        </div>
    </div>
</div>
