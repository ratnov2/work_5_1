@props([
    'color',
    'size' => 'normal'
])

<button {{
    $attributes->class([
        'bg-red-300' => $color == 'red',
        'bg-orange-300' => $color == 'yellow',
        'bg-indigo-300' => $color == 'indigo',
        'bg-blue-300' => $color == 'blue',
        'bg-green-300' => $color == 'green',
        'bg-orange-300' => $color == 'orange',
        'bg-gray-300' => $color == 'gray',

        'text-xs' => $size == 'small',
        'px-4' => $size == 'small',
        'py-2' => $size == 'small',
        'text-sm' => $size == 'normal',
        'px-7' => $size == 'normal',
        'py-3' => $size == 'normal',

        'bg-opacity-90',
        'inline-flex',
        'whitespace-nowrap',
        'items-center',
        'justify-center',
        'rounded',
        'text-gray-1000',
        'text-center',
        'uppercase',
        'font-bold',
        'w-full',
    ])
}}>
    {{$slot}}
</button>
