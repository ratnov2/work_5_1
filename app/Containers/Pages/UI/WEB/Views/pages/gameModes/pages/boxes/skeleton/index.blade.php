<div class="w-full h-full flex flex-col space-y-5 overflow-y-auto pr-2">
    @for ($i = 0; $i < 5; $i++)
        <div class="flex flex-col w-full space-y-2">
            <div class="flex flex-col items-center justify-center relative w-full">
                <p class="h-5 skeleton-text w-40 z-10"></p>
                <div class="flex h-0.5 bg-gray-600 w-full opacity-10 absolute z-0 bottom-0"></div>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">
                @for ($k = 0; $k < 4; $k++)
                    @include('box::skeleton.box')
                @endfor
            </div>
        </div>
    @endfor
</div>

