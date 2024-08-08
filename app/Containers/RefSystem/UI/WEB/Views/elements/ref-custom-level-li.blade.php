<div class="flex flex-col items-center justify-center w-full space-y-5">
    <div class="w-full flex items-center flex-nowrap justify-between space-x-1 text-gray-500 px-2">
        <div class="w-1/4 flex justify-start">
            <span class="whitespace-nowrap text-xs">№</span>
        </div>
        <div class="w-1/4 flex justify-center">
            <span class="whitespace-nowrap text-xs">Имя уровня</span>
        </div>
        <div class="w-1/4 flex justify-end">
            <span class="whitespace-nowrap text-xs">Ваш бонус</span>
        </div>
        <div class="w-1/4 flex justify-end">
            <span class="whitespace-nowrap text-xs">Реф. бонус</span>
        </div>
    </div>

    <div class="flex flex-col w-full space-y-2">
        <div class="w-full flex items-center flex-nowrap justify-between space-x-1 rounded-lg bg-gray-800 p-2">
            <div class="w-1/4 flex justify-start">
                <span class="whitespace-nowrap w-8 h-8 flex items-center justify-center flex-shrink-0 rounded-lg text-white bg-green-300 text-xs md:text-sm"><i class="fas fa-user"></i></span>
            </div>
            <div class="w-1/4 flex justify-center">
                <span class="whitespace-nowrap text-gray-400 font-bold text-xs md:text-sm">{{$ref_level->name}}</span>
            </div>
            <div class="w-1/4 flex justify-end">
                <span class="whitespace-nowrap text-green-300 text-xs md:text-sm">{{$ref_level->bonus_precent}} %</span>
            </div>
            <div class="w-1/4 flex justify-end">
                <span class="whitespace-nowrap text-green-300 text-xs md:text-sm">{{$ref_level->ref_bonus_precent}} %</span>
            </div>
        </div>
    </div>
</div>
