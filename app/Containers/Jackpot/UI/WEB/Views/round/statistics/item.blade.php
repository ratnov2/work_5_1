<div class="h-full px-3 w-full sm:w-fit sm:px-5 py-1 flex items-center justify-center space-x-1 sm:space-x-2 bg-gray-900">
    <span class="text-xl sm:text-2xl text-white">{!! $icon !!}</span>
    <div class="flex flex-col -space-y-1 dm:-space-y-1.5">
        <span class="text-xs sm:text-sm text-gray-300 whitespace-nowrap">{{$title}}</span>
        <span class="text-md sm:text-lg text-green-300">
            {{$slot}}
        </span>
    </div>
</div>
