<div class="flex space-x-1 items-center">
    <div class="relative flex items-center justify-center">
        <span class="text-transparent bg-clip-text bg-gradient-to-br from-orange-300 to-orange-400 text-2xl md:text-4xl opacity-5 absolute z-10">
            {!! $icon !!}
        </span>
        <span class="text-transparent bg-clip-text bg-gradient-to-br from-orange-300 to-orange-400 text-lg md:text-2xl relative z-20">
            {!! $icon !!}
        </span>
    </div>
    <div class="flex flex-col">
        <span class="text-gray-100 font-bold text-sm md:text-lg">{!! $value !!}</span>
        <span class="text-gray-500 text-xss md:text-xs -mt-1 md:-mt-2.5">{{$desc}}</span>
    </div>
</div>
