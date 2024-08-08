<div class="flex flex-col space-y-2">
    <div class="flex flex-col items-center space-y-2">
        {{-- Top panel --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-2 w-full h-[290px]">
            {{-- Chart --}}
            <div class="col-span-1 rounded-lg flex justify-center items-center overflow-hidden relative bg-gray-900 p-4">
                <div class="skeleton bg-gray-800 flex flex-shrink-0 items-center justify-center relative z-10 rounded-full" style="width: 200px; height: 200px">
                </div>
            </div>

            {{-- Bets --}}
            <div class="col-span-1 xl:col-span-2 overflow-y-auto">
                @for ($i = 0; $i < 3; $i++)
                    <div class="bg-gray-900 rounded-lg flex flex-col flex-shrink-0">
                        <div class="p-2 flex items-center justify-between">
                            <div class="flex space-x-2 items-center">
                                <div class="rounded-lg h-10 w-10 skeleton-img"></div>
                                <div class="flex flex-col space-y-1">
                                    <span class="w-24 h-3 skeleton-text"></span>
                                    <span class="w-32 h-2.5 skeleton-text"></span>
                                </div>
                            </div>
                            <div class="flex space-x-2 items-center">
                                <div class="h-9 w-24 skeleton-block rounded-md"></div>
                                <div class="h-9 w-24 skeleton-block rounded-md"></div>
                            </div>
                        </div>

                        <div class="border-t border-gray-700 flex bg-gray-900 space-x-0.5">
                            @for ($k = 0; $k < 4; $k++)
                                <div class="w-32 h-20 bg-gray-800 flex items-center p-4 relative flex-shrink-0">
                                    <div class="flex flex-col absolute z-20 bottom-2 left-2 space-y-1">
                                        <span class="h-2.5 w-20 skeleton-text"></span>
                                        <span class="h-2 w-full skeleton-text"></span>
                                    </div>
                                    <div class="w-full h-full animate-pulse-fast">
                                        <div class="w-full h-full bg-no-repeat bg-contain bg-center opacity-30" style="background-image: url({{asset('/img/ak-47.png')}})"></div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="rounded-lg overflow-hidden h-16 flex justify-between w-full bg-gray-800 pl-5">
            <div class="flex items-center space-x-5">
                <div class="flex flex-col space-y-1">
                    <span class="skeleton-block w-12 h-2 rounded-full"></span>
                    <span class="skeleton-block w-7 h-2 rounded-full"></span>
                </div>
                <div class="flex space-x-2">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="flex flex-col space-y-0.5 items-center">
                            <div class="rounded-md h-9 w-9 skeleton-img"></div>
                            <span class="h-2 w-8 skeleton-text"></span>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="flex space-x-0.5">
                @for ($i = 0; $i < 3; $i++)
                    <div class="bg-gray-700 bg-opacity-20 h-full flex px-6">
                        <div class="flex space-x-2 items-center">
                            <div class="rounded-lg h-7 w-8 skeleton-img"></div>
                            <div class="flex flex-col space-y-1">
                                <span class="w-14 h-3 skeleton-text"></span>
                                <span class="w-10 h-5 skeleton-text"></span>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="w-full h-full bg-gray-900 flex flex-col space-y-1 rounded-md p-4 mt-2">
        <span class="h-2 w-60 skeleton-text"></span>

        <div class="flex flex-col flex-grow items-center space-y-2 overflow-y-auto overflow-x-hidden pr-2">
            @for ($i = 0; $i < 10; $i++)
                <div class="bg-gray-800 rounded-md w-full items-center flex">
                    <div class="p-2 flex space-x-2 items-center flex flex-nowrap w-60 flex-shrink-0">
                        <div class="rounded-lg h-10 w-10 skeleton-img"></div>
                        <div class="inline-flex flex-col space-y-1">
                            <span class="h-3 skeleton-text w-20"></span>
                            <span class="h-2 skeleton-text w-20"></span>
                            <span class="h-2 skeleton-text w-10"></span>
                        </div>
                    </div>
                    <div class="flex-grow overflow-hidden h-full flex space-x-0.5">
                        @for ($k = 0; $k < 6; $k++)
                            <div class="w-28 h-full bg-gray-800 flex flex-shrink-0 items-center relative">
                                <div class="flex flex-col absolute z-20 bottom-2 left-2 space-y-1">
                                    <span class="h-2.5 w-20 skeleton-text"></span>
                                    <span class="h-2 w-full skeleton-text"></span>
                                </div>
                                <div class="w-full h-full animate-pulse-fast">
                                    <div class="w-full h-full bg-no-repeat bg-contain bg-center opacity-30" style="background-image: url({{asset('/img/ak-47.png')}})"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
