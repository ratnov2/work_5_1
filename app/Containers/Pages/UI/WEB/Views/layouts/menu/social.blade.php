@php
    $links = [];
    if($youtube_link) $links[] = ['href' => $youtube_link, 'icon' => '<i class="fab fa-youtube"></i>'];
    if($vk_link) $links[] = ['href' => $vk_link, 'icon' => '<i class="fab fa-vk"></i>'];
    if($telegram_link) $links[] = ['href' => $telegram_link, 'icon' => '<i class="fab fa-telegram-plane"></i>'];
@endphp

@if (count($links) > 0)
    <div class="flex space-x-2">
        @foreach ($links as $link)
            <a href="{{$link['href']}}" target="_blank" class="text-2xl text-gray-700 hover:text-orange-300 transition duration-150">
                {!! $link['icon'] !!}
            </a>
        @endforeach
    </div>
@endif

