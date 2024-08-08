<div class="flex flex-col w-full overflow-hidden rounded-lg bg-gray-900">
    <div class="h-[150px] w-full flex bg-gray-800 bg-opacity-50">
        <div class="w-[160px] flex relative">
            <span class="absolute h-2 top-3 right-3 w-20 rounded-md skeleton-block"></span>
            @include('item::skeleton.card')
        </div>
        <div class="flex-grow flex flex-col items-start justify-center p-2 space-y-2">
            <div class="w-24 h-2 rounded-full skeleton-block"></div>
            <div class="w-full h-3 rounded-full skeleton-block"></div>
            <div class="flex rounded w-full h-12 skeleton-block"></div>
            <span class="w-24 h-2 mx-auto rounded-md skeleton-block"></span>
        </div>
    </div>
    <div class="h-[42px] w-full flex justify-between items-center p-2 bg-gray-800">
        <span class="w-40 h-3 rounded-md skeleton-block"></span>
        <span class="w-24 h-3 rounded-md skeleton-block"></span>
    </div>
</div>
