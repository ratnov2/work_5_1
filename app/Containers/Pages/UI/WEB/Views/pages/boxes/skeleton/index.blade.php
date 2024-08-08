<div class="space-y-10">
    @for ($i = 0; $i < 5; $i++)
        <div class="flex flex-col w-full">
            <p class="h-5 rounded-full skeleton-block w-48 xl:w-96 mb-2"></p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @for ($k = 0; $k < 4; $k++)
                    @include('box::skeleton.box')
                @endfor
            </div>
        </div>
    @endfor
</div>
