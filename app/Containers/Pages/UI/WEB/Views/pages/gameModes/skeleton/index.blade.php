<div class="grid grid-cols-1 lg:grid-cols-12 items-start gap-2 lg:-mx-5 h-[700px] overflow-hidden">
    {{-- Invent --}}
    <div class="col-span-1 lg:col-span-3 h-[700px]">
        @component('gamemodes::skeleton.invent')@endcomponent
    </div>

    {{-- Games --}}
    <div class="col-span-1 lg:col-span-6 flex flex-col h-[700px]">
        <nav class="h-[61px] bg-gray-900 flex flex-shrink-0 justify-start rounded-md overflow-hidden space-x-0.5">
            @for ($i = 0; $i < 5; $i++)
                <span class="justify-stretch flex items-center px-5 py-2 bg-gray-900 bg-opacity-30 flex-col border-t border-gray-800 space-y-2">
                    <span class="w-10 h-10 rounded-md skeleton-img"></span>
                    <span class="w-12 h-3 rounded-full skeleton-block"></span>
                </span>
            @endfor
        </nav>

        <div class="h-full w-full skeleton bg-gray-900 rounded-md mt-2"></div>
    </div>

    {{-- Chat --}}
    <div class="col-span-1 lg:col-span-3 h-[700px]">
        @component('chat::skeleton.card')@endcomponent
    </div>
</div>
