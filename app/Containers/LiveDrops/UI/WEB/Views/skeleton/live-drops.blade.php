<div class="flex space-x-1 w-full max-w-full overflow-hidden bg-gray-900 relative border-b border-gray-900">
    @for ($i = 0; $i < 25; $i++)
        <div class="w-36 h-24 flex-shrink-0 relative flex items-center justify-center overflow-hidden rounded-md">
            @include('item::skeleton.card')
        </div>
    @endfor
</div>
