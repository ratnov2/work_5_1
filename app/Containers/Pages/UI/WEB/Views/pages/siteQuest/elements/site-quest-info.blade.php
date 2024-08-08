<div class="flex items-start space-x-2">
    <span>Тип задания:</span>
    <p x-show="{{$site_quest}}.is_reusable" class="text-blue-300">Многоразовое</p>
    <p x-show="!{{$site_quest}}.is_reusable" class="text-yellow-400">Одноразовое</p>
</div>

<div class="flex items-center space-x-2">
    <span>Награда:</span>
    <span class="text-green-300 text-lg space-x-1"><span x-text="{{$site_quest}}.reward_price"></span><x-icons.currency /></span>
</div>

<div class="flex items-start space-x-2">
    <span>Описание:</span>
    <p x-html="{{$site_quest}}.description"></p>
</div>
