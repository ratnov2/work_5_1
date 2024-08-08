<div class="flex flex-col space-y-2">
    <div class="relative rounded-md flex items-center justify-center flex-wrap sm:flex-nowrap sm:justify-between bg-gray-800 bg-opacity-40 p-10">
        <div class="w-full sm:w-max flex flex-col px-4 space-y-2">
            <span class="h-5 w-44 skeleton-text"></span>
            <p class="h-4 w-full skeleton-text"></p>
        </div>
        <div class="w-full sm:w-max h-full flex flex-col items-center justify-center p-0 xl:p-2 space-y-2">
            <span class="h-9 skeleton-text w-48"></span>
            <span class="h-3 skeleton-text w-48"></span>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-2 items-start">
        @for ($i = 0; $i < 3; $i++)
            <div class="relative rounded-md w-full h-[164px]">
                <div class="absolute w-full h-full z-0 bg-gray-800 bg-opacity-40"></div>
                <div class="z-10 relative grid grid-cols-2 h-full">
                    <div class="w-full h-full relative">
                        <span class="z-20 absolute top-1 right-2 skeleton-text h-2"></span>
                        @include('item::skeleton.card')
                    </div>
                    <div class="flex flex-col space-y-3 items-center justify-center py-3 pr-3">
                        <div class="w-full flex justify-center rounded-md relative">
                            <div class="w-20 h-20 rounded-md skeleton-img"></div>
                            <div class="absolute z-10 -bottom-2 right-2">
                                <div class="rounded-md z-0 w-10 h-10 skeleton-img"></div>
                            </div>
                        </div>
                        <div class="w-full flex flex-col items-end space-y-0.5">
                            <span class="w-28 h-3 skeleton-text"></span>
                            <span class="w-14 h-2 skeleton-text"></span>
                            <span class="w-14 h-1.5 skeleton-text"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endfor

        @for ($i = 0; $i < 7; $i++)
            <div class="rounded-md relative relative h-[72px] flex items-center">
                <span class="absolute z-10 top-2 left-3 skeleton-text h-3 w-3"></span>
                <div class="z-0 bg-gray-800 bg-opacity-40 absolute w-full h-full"></div>
                <div class="z-10 p-3 relative flex flex-nowrap items-center space-x-2 ml-5">
                    <div class="w-8 h-8 rounded-lg skeleton-img"></div>
                    <div class="flex flex-col space-y-0.5">
                        <span class="w-28 h-3 skeleton-text"></span>
                        <span class="w-14 h-2 skeleton-text"></span>
                        <span class="w-14 h-1 skeleton-text"></span>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
