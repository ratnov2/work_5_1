<div class="grid grid-cols-1 xl:grid-cols-3 gap-2">
    <div class="col-span-2 flex flex-col space-y-2 overflow-y-auto">
        <p class="h-5 rounded-full skeleton-block w-48 xl:w-96"></p>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2">
            @for ($i = 0; $i < 10; $i++)
                @include('contest::skeleton.card')
            @endfor
        </div>
    </div>

    <div class="col-span-1 flex flex-col space-y-3 overflow-y-auto">
        <p class="h-5 rounded-full skeleton-block w-48 xl:w-96"></p>
        <div class="grid grid-cols-1 gap-2">
            @for ($i = 0; $i < 3; $i++)
                @include('contest::skeleton.card')
            @endfor
        </div>
    </div>
</div>

