@props([
    'desc',
    'color',
    'title',
])

<div {{
    $attributes->class([
        'w-full h-full relative flex flex-col items-center justify-center backdrop-blur-sm px-7 py-4',
        'bg-[#552f34]' => $color == 'red',
        'bg-[#40436e]' => $color == 'indigo',
        'bg-[#589f72]' => $color == 'green',
        'bg-[#28252f]' => $color == 'gray',
    ])
}}>
    @isset($title)
        <span @class(['font-bold', 'text-md', 'whitespace-nowrap', 'line-clamp-1', 'text-ellipsis', 'overflow-hidden', 'uppercase',
            'text-red-100' => $color == 'red',
            'text-indigo-100' => $color == 'indigo',
            'text-green-100' => $color == 'green',
            'text-gray-100' => $color == 'gray',
        ])>{{$title}}</span>
    @endisset

    @isset($desc)
        <p class="text-center text-sm text-gray-200">{{$desc}}</p>
    @endisset

    {{$slot}}
</div>
