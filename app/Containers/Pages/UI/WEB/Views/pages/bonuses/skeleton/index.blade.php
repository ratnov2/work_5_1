<div class="flex flex-col space-y-2">
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">
        <div class="flex flex-col space-y-3 items-center">
            <div class="grid gap-2 grid-cols-1 md:grid-cols-2 w-full items-center">
                @for ($k = 0; $k < 2; $k++)
                    @include('box::skeleton.box')
                @endfor
            </div>
            <div class="rounded-md skeleton-block h-5 w-1/4"></div>
        </div>
        <div class="flex flex-col space-y-3 items-center">
            <div class="grid gap-2 grid-cols-1 md:grid-cols-2 w-full items-center">
                @for ($k = 0; $k < 2; $k++)
                    @include('contest::skeleton.card')
                @endfor
            </div>
            <div class="rounded-md skeleton-block h-5 w-1/4"></div>
        </div>
    </div>

    {{-- Categories --}}
    <div class="flex h-16 bg-gray-800 bg-opacity-50 -mx-2 lg:-mx-7">
        <div class="flex items-center space-x-1 mx-auto h-full overflow-hidden">
            <span class="h-3 w-32 mr-4 skeleton-block rounded-lg"></span>
            @for ($i = 0; $i < 4; $i++)
                <span class="h-full relative bg-gray-800 px-4 flex items-center justify-center hover:no-underline">
                    <span class="h-3 w-24 skeleton-block rounded-lg"></span>
                    <div class="h-0.5 w-full bg-gray-600 absolute bottom-0"></div>
                </span>
            @endfor
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-6 gap-2">
        {{-- Left banners --}}
        <div class="hidden col-span-1 lg:flex justify-center">
            @include('banner::skeleton.side-banner')
        </div>

        <div class="col-span-1 sm:col-span-4">
            {{-- Top Banner --}}
            <div class="mb-5 h-[320px] rounded-lg skeleton-img"></div>

            <div class="my-5 md:my-10 flex flex-col w-full items-center space-y-2">
                {{-- Category name --}}
                <div class="w-full border-b border-gray-700 flex justify-center">
                    <span class="inline-flex h-10 w-1/5 rounded-t-lg skeleton-block"></span>
                </div>
                {{-- Sites --}}
                <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 justify-center gap-2">
                    @for ($k = 0; $k < 10; $k++)
                        @include('site::skeleton.card')
                    @endfor
                </div>
            </div>
        </div>
        {{-- Right banners --}}
        <div class="hidden col-span-1 lg:flex justify-center">
            @include('banner::skeleton.side-banner')
        </div>
    </div>
</div>
