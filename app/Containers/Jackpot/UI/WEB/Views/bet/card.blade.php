<div class="bg-gray-900 rounded-lg flex flex-col overflow-hidden">
    <div class="p-2 flex items-center justify-between">
        <div class="flex space-x-2">
            <div class="rounded-lg h-10 w-10 bg-gray-400 border-2 bg-cover bg-center bg-no-repeat"
                :style="{
                    backgroundImage: `url(${bet.player.image})`,
                    borderColor: `${ {{$alpine__color}} }`
                }">
            </div>
            <div class="flex flex-col">
                <span class="text-gray-100 text-sm max-w-32 line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden" x-text="{{$alpine__bet}}.player.name"></span>
                <span class="text-gray-400 text-xs">Билеты: #<span x-text="{{$alpine__bet}}.tickets_from"></span> - #<span x-text="{{$alpine__bet}}.tickets_to"></span></span>
            </div>
        </div>
        <div class="flex space-x-2 items-center">
            <span class="flex items-center space-x-1 text-green-300">
                <x-icons.currency />
                <span x-text="{{$alpine__bet}}.sum"></span>
            </span>
            <span class="flex items-center space-x-1 text-indigo-300">
                <span x-text="roundLikePHP(({{$alpine__bet}}.sum * 100 / {{$alpine__bank}}), 2)"></span>
                <span>%</span>
            </span>
        </div>
    </div>
    <div class="border-t border-gray-700 flex space-x-0.5 flex-nowrap overflow-y-hidden overflow-auto bg-gray-900">
        <template x-for="(bet_item, index) in {{$alpine__bet}}.items" :key="{{$alpine__bet}}.id + '_bet_item' + index">
            <div class="w-32 h-20 flex-shrink-0 relative flex items-center justify-center overflow-hidden">
                @component('item::components.item-card', ['alpine__item' => 'bet_item'])@endcomponent
            </div>
        </template>
    </div>
</div>
