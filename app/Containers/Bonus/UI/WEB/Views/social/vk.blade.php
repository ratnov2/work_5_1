<div class="w-full flex justify-center items-center rounded-md p-4 bg-gray-800 space-x-10">
    <div class="relative inline-flex justify-center items-center">
        <i class="text-6xl text-white fab fa-vk relative z-10"></i>
        <i class="text-[100px] text-white opacity-10 absolute z-0 fab fa-vk"></i>
    </div>

    <div class="inline-flex flex-col items-start space-y-2">
        <p class="text-white text-xs">Привяжи аккаунт VK и мгновенно получи скин!</p>
        <a href="{{route('player.vk.auth')}}">
            <x-buttons.default color="green">
                <span>Привязать</span>
            </x-buttons.default>
        </a>
    </div>
</div>
