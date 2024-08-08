<div class="relative flex flex-col h-full w-full">
    <div class="flex items-center justify-start w-full px-6 flex-shrink-0 h-20 border-b border-gray-700 bg-gray-900 rounded-t-md">
        <span class="w-28 h-3 rounded-full skeleton-block inline-flex"></span>
    </div>

    <div class="h-96 overflow-hidden bg-gray-900 flex-grow p-4">
        <div class="space-y-3 flex flex-col">
            @for ($i = 0; $i < 10; $i++)
                <div class="rounded-tl-xl rounded-tr-md rounded-br-xl rounded-bl-md bg-gray-700 bg-opacity-20 p-2 w-full flex items-start">
                    <div class="w-10 h-10 rounded-md skeleton-img mr-2"></div>
                    <div class="flex flex-col flex-grow space-y-2">
                        <span class="h-4 w-28 rounded-full skeleton-block"></span>
                        <span class="h-4 w-full rounded-full skeleton-block"></span>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="flex justify-center items-center flex-shrink-0 bg-gray-800 bg-opacity-50 w-full border-t border-gray-700 rounded-b-md relative">
        <div class="flex items-center justify-center w-full space-x-2">
            <div class="flex w-full h-full p-4 items-scretch space-x-1">
                <div class="h-10 skeleton-block bg-opacity-60 rounded-md w-full"></div>
                <span class="flex items-center justify-center flex-shrink-0 w-10 h-10 skeleton-block rounded-md"></span>
            </div>
        </div>
    </div>
</div>

