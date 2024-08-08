<div class="grid grid-cols-1 lg:grid-cols-3 gap-2 items-start">
    <div class="col-span-1 lg:col-span-2 grid gap-2 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <div class="col-span-1 md:col-span-1 lg:col-span-1 flex flex-col items-center justify-center p-5 space-y-5 rounded-lg bg-gray-900">
            <span class="skeleton-text h-3 w-44"></span>

            <div class="w-40 h-40 flex flex-shrink-0 rounded-full skeleton-block"></div>

            <div class="flex flex-col space-y-2 items-center">
                <div class="flex items-center space-x-2 text-lg">
                    <span class="skeleton-text h-3 w-12"></span>
                    <span class="opacity-50 skeleton-text h-3 w-3"></span>
                    <span class="opacity-50 skeleton-text h-3 w-12"></span>
                </div>
                <span class="skeleton-text h-3 w-40"></span>
            </div>
        </div>

        <div class="col-span-1 md:col-span-1 lg:col-span-2 flex flex-col w-full">
            <div class="flex flex-col p-3 mb-2 rounded-lg bg-gray-900 space-y-2">
                @for($i = 0; $i < 2; $i++)
                    <div class="flex items-center h-9">
                        <h5 class="h-full w-20 rounded-tl-md rounded-bl-md skeleton-block inline-flex flex-shrink-0"></h5>
                        <div class="h-full w-full rounded-tr-md rounded-br-md skeleton-block"></div>
                        <span class="ml-2 w-24 h-full rounded-md skeleton-block"></span>
                    </div>
                @endfor
            </div>
            <div class="flex flex-col p-3 rounded-lg bg-gray-900 h-full space-y-3">
                <div class="flex justify-start border-b border-gray-700">
                    <span class="skeleton-text h-3 w-44 mb-1"></span>
                </div>
                <p class="h-3 w-1/3 skeleton-text"></p>
                <div class="w-full h-full rounded-lg flex items-start justify-center space-x-2 flex-grow-1">
                    @for($i = 0; $i < 2; $i++)
                        <div class="flex flex-col items-center justify-center rounded-lg p-2 bg-gray-800 flex-shrink-0 space-y-2">
                            <span class="skeleton-img h-5 w-6 rounded-md"></span>
                            <span class="skeleton-text h-5 w-3"></span>
                            <span class="skeleton-text h-2 w-14"></span>
                        </div>
                    @endfor
                    <div class="flex flex-col items-start flex-grow space-y-1">
                        <h5 class="skeleton-text h-6 w-full max-w-[60rem]"></h5>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 h-8 rounded-md skeleton-block"></div>
                            <span class="w-8 h-8 rounded-md skeleton-block"></span>
                        </div>
                        <p class="skeleton-text h-2 w-40"></p>
                    </div>
                </div>

                <div class="rounded-lg p-3 bg-gray-800 w-full space-y-1">
                    <p class="skeleton-text w-1/3 h-2"></p>
                    <ul class="flex flex-col space-y-1">
                        <li class="skeleton-text w-2/4 h-2"></li>
                        <li class="skeleton-text w-2/4 h-2"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-1 flex flex-col bg-gray-900 p-3 rounded-lg items-center space-y-5">
        <div class="flex items-center justify-between w-full px-2 py-2 rounded">
            <span class="skeleton-text h-4 w-40"></span>
        </div>

        <div class="flex flex-col items-center justify-center w-full space-y-5">
            <div class="w-full h-10 flex items-center flex-nowrap justify-between space-x-1 px-2">
                @for($i = 0; $i < 4; $i++)
                    <div class="w-1/4 flex justify-start">
                        <span class="skeleton-text h-2 w-10"></span>
                    </div>
                @endfor
            </div>

            <div class="flex flex-col w-full space-y-2">
                @for($i = 0; $i < 5; $i++)
                    <div class="h-10 flex justify-center w-full rounded-md skeleton-block"></div>
                @endfor
            </div>
        </div>
    </div>
</div>

