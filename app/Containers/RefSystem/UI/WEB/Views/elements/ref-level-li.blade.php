<div class="w-full flex items-center flex-nowrap justify-between space-x-1 rounded-lg bg-gray-800 p-2">
    <div class="w-1/4 flex justify-start">
        <span class="text-xs md:text-sm whitespace-nowrap w-8 h-8 flex items-center justify-center flex-shrink-0 rounded-lg bg-opacity-70 text-indigo-200 border-2 border-indigo-400 bg-indigo-400 bg-opacity-70">{{$ref_level->level}}</span>
    </div>
    <div class="w-1/4 flex justify-center">
        <span class="whitespace-nowrap text-green-300 font-abold text-xs md:text-sm">{{$ref_level->sum_payments}} <i class="fas fa-coin"></i></span>
    </div>
    <div class="w-1/4 flex justify-end">
        <span class="whitespace-nowrap text-green-300 text-xs md:text-sm">{{$ref_level->bonus_precent}} %</span>
    </div>
    <div class="w-1/4 flex justify-end">
        <span class="whitespace-nowrap text-green-300 text-xs md:text-sm">{{$ref_level->ref_bonus_precent}} %</span>
    </div>
</div>
