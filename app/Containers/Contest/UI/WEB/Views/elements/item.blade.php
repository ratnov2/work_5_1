<div class="w-44 h-full relative flex items-center justify-center overflow-hidden">
    <span class="z-20 absolute top-1 right-1 text-[10px] text-green-300">
        <i class="fas fa-coin"></i>
        <span x-text="{{$alpine__item}}.price"></span>
    </span>
    @component('item::components.item-card', ['alpine__item' => $alpine__item])@endcomponent
</div>
