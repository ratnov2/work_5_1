<div class="space-y-2 lg:mx-auto lg:container">
    <div class="grid gap-2 grid-cols-1 xl:grid-cols-2">
        <div class="grid gap-2 grid-cols-1 lg:grid-cols-2 rounded bg-gray-900">
            <div class="skeleton bg-gray-1000 bg-opacity-20"></div>
            <div class="skeleton bg-gray-900"></div>
        </div>

        <div class="flex flex-col space-y-2">
            <div class="grid gap-2 grid-cols-1 lg:grid-cols-2">
                <div class="skeleton bg-gray-900 rounded h-[200px]"></div>
                <div class="skeleton bg-gray-900 rounded h-[200px]"></div>
            </div>

            <div class="flex flex-nowrap space-x-2">
                @for ($i = 0; $i < 3; $i++)
                    <div class="skeleton rounded w-full bg-gray-800 h-[72px]"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- Invent --}}
    <div class="flex flex-col bg-gray-900 rounded-lg space-y-2 w-full h-full px-4 py-2">
        <div class="flex items-center flex-col space-y-1 sm:space-y-0 sm:flex-row justify-center sm:justify-between">
            <p class="h-5 w-28 md:w-40 skeleton-text"></p>
            <div class="flex space-x-2">
                <div class="flex items-center space-x-2 h-3">
                    <span class="h-full w-6 skeleton-text"></span>
                    <span class="h-full w-10 skeleton-text"></span>
                </div>
                <span class="h-3 w-28 md:w-44 skeleton-text"></span>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-0.5 sm:grid-cols-4 md:grid-cols-5 flex-none lg:grid-cols-none lg:flex lg:flex-wrap lg:justify-start rounded-lg shadow-md bg-gray-900 bg-opacity-50">
            @for ($i = 0; $i < 10; $i++)
                <div class="w-full lg:w-40 h-28 relative flex items-center justify-center overflow-hidden rounded">
                    @include('item::skeleton.card')
                </div>
            @endfor
        </div>
    </div>
</div>
