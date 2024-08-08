<div class="relative flex flex-col bg-gray-800 bg-opacity-40 rounded-lg p-2 md:p-4 h-full overflow-hidden">
    <div class="flex items-center justify-between">
        <p></p>
        <span></span>
    </div>

    <div class="flex-grow mt-2 overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-50">
        <div class="grid grid-cols-3 gap-0.5 items-start pr-1">
            @for ($i = 0; $i < 20; $i++)
                <div class="flex h-24 bg-gray-900">
                    @include('item::skeleton.card')
                </div>
            @endfor
        </div>
    </div>

    <div class="flex mt-2 items-center relative gap-2">
        <span class="w-full h-12 skeleton-block rounded"></span>
        <span class="w-full h-12 skeleton-block rounded"></span>
    </div>
</div>
