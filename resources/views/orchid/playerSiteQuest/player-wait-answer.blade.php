@if (!is_null($wait_answer))
    <div class="flex flex-col space-y-7">
        <div class="flex flex-col space-y-2">
            <span>Изображения игрока:</span>

            @if (!is_null($wait_answer['images']))     
                <div class="flex flex-wrap">
                    @foreach ($wait_answer['images'] as $image)
                        <img class="h-[300px]" src="{{$image}}" alt="image">
                    @endforeach
                </div>
            @else
                <span>Не найдено</span>
            @endif
        </div>

        <div class="flex flex-col space-y-2">
            <span>Текст игрока:</span>

            @if (!is_null($wait_answer['text']))     
                <textarea cols="30" readonly rows="10" class="border border-gray-500 w-full p-2.5 rounded-lg">{{$wait_answer['text']}}</textarea>
            @else
                <span>Не найдено</span>
            @endif
        </div>
    </div>
@else
    <div>Не найдено</div>
@endif