<div class="flex flex-col items-center space-y-2">
    <div class="flex gap-2 w-full justify-center items-center relative">
        <div class="h-124 md:h-100 w-full bg-gray-900 flex items-center justify-center pr-0 md:pr-20 rounded-l-lg">
            <div class="w-full md:w-2/3 h-full md:h-3/4 rounded-lg skeleton-img"></div>
        </div>

        <div class="absolute z-20 top-0 md:top-auto flex flex-col space-y-3">
            <div class="relative flex items-center justify-center rounded-full h-40 w-40 bg-gray-800 border-8 border-gray-1000">
                <div class="absolute z-0 rounded-full w-full h-full flex items-center justify-center skeleton-img"></div>
            </div>
            <div class="bg-gray-1000 p-2 rounded-2xl">
                <div class="w-full h-12 skeleton-block rounded-lg"></div>
            </div>
        </div>

        <div class="h-124 md:h-100 w-full bg-gray-900 flex items-center justify-center pl-0 md:pl-20 rounded-r-lg">
            <div class="w-full md:w-2/3 h-full md:h-3/4 rounded-lg skeleton-img"></div>
        </div>
    </div>

    <div class="flex flex-col w-full bg-gray-900 p-5 rounded-md space-y-2">
        <div class="flex gap-2 justify-between">
            <div class="hidden md:flex flex-grow items-center gap-2">
                <span class="w-32 h-3 rounded-full skeleton-block"></span>
            </div>
            <div class="grid grid-cols-3 gap-1 flex-grow">
                <span class="w-full h-full rounded-full skeleton-block"></span>
                <span class="w-full h-full rounded-full skeleton-block"></span>
                <span class="w-full h-full rounded-full skeleton-block"></span>
            </div>
        </div>
        <div class="h-100 flex-grow overflow-hidden pr-1">
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-1">
                @for ($i = 0; $i < 25; $i++)
                    <div class="w-full h-28">
                        @include('item::skeleton.card')
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
