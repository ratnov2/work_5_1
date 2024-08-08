<div class="flex flex-col space-y-2">
    <p class="text-md text-gray-200">Для пополнения счета осуществите перевод на QIWI кошелек с указанием комментария</p>
    <div class="flex w-full sm:w-auto">
        <div class="text-sm p-3 rounded-tl-md rounded-bl-md text-green-300 border-t-2 border-l-2 border-b-2 border-green-400 bg-gray-700">Qiwi</div>

        <input value="{{$phone_number}}" type="number" readonly class="w-full sm:w-auto border-t-2 border-r-2 border-b-2 border-green-400 focus:outline-none rounded-tr-md rounded-br-md focus:border-green-400 text-green-300 p-3 bg-gray-800 text-sm">

        <x-buttons.default onclick="copyToClipboard('{{$phone_number}}')" class="ml-2" size="small" color="green">
            <i class="fas fa-copy"></i>
        </x-buttons.default>
    </div>
    <div class="flex w-full sm:w-auto">
        <div class="text-sm p-3 rounded-tl-md rounded-bl-md text-green-300 border-t-2 border-l-2 border-b-2 border-green-400 bg-gray-700">РУБ</div>

        <input value="{{$sum}}" type="number" step="0.01" readonly class="w-full sm:w-auto border-t-2 border-r-2 border-b-2 border-green-400 focus:outline-none rounded-tr-md rounded-br-md focus:border-green-400 text-green-300 p-3 bg-gray-800 text-sm">

        <x-buttons.default onclick="copyToClipboard('{{$sum}}')" class="ml-2" size="small" color="green">
            <i class="fas fa-copy"></i>
        </x-buttons.default>
    </div>
    <div class="flex w-full sm:w-auto">
        <div class="text-sm p-3 rounded-tl-md rounded-bl-md text-green-300 border-t-2 border-l-2 border-b-2 border-green-400 bg-gray-700">Комментарий</div>

        <input value="{{$comment}}" type="text" readonly class="w-full sm:w-auto border-t-2 border-r-2 border-b-2 border-green-400 focus:outline-none rounded-tr-md rounded-br-md focus:border-green-400 text-green-300 p-3 bg-gray-800 text-sm">

        <x-buttons.default onclick="copyToClipboard('{{$comment}}')" class="ml-2" size="small" color="green">
            <i class="fas fa-copy"></i>
        </x-buttons.default>
    </div>
    <div class="mt-auto">
        <x-banners.default class="rounded-md" title="ВНИМАНИЕ" color="red">
            <p class="text-sm w-80">Платежи без указания комментария, с неверно указанным комментарием или неверно переведенной суммой обработаны не будут. Будьте внимательны!</p>
        </x-banners.default>
    </div>
</div>
