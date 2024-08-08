<div>
    @component('statistics::item', [
        'icon' => '<i class="fas fa-swords"></i>',
        'value' => '<span x-text="count_success_trades"></span>',
        'desc' => 'трейдов'
    ]) @endcomponent
</div>
