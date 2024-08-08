@props(['size', 'color'])

<div {{ $attributes->class([
    'items-center', 'justify-center', 'flex', 'px-2.5', 'py-0.5', 'rounded', 'bg-gray-900', 'relative', 'font-bold',
    'text-[11px]' => $size == 'small',
    'py-0' => $size == 'small',
    'px-1' => $size == 'small',
    'text-lg' => $size == 'normal',
    'py-2' => $size == 'normal',
    'px-4' => $size == 'normal',

    'text-orange-300' => $color == 'orange',
    'text-indigo-300' => $color == 'indigo',
    'text-purple-300' => $color == 'purple',
    'text-yellow-300' => $color == 'yellow',
    'text-red-300' => $color == 'red',
    'text-green-300' => $color == 'green',
]) }}>
    {{$slot}}
</div>
