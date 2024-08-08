@props([
    'isActing',
    'isDisabled' => 'false',
    'acting' => '',
    'action',
])

<x-buttons.default {{ $attributes }} ::disabled="{{ $isActing }} || {{ $isDisabled }}" ::class="{{ $isActing }} || {{ $isDisabled }} ? 'opacity-20 grayscale' : 'opacity-100 grayscale-0'">
    <span x-show="{{ $isActing }}" class="w-full flex items-center justify-center space-x-1">
        <span class="h-5 w-5 inline-flex"><x-icons.spinner /></span>
        <span>{!! $acting !!}</span>
    </span>

    <span class="w-full" x-show="!{{ $isActing }}">
        {!! $action !!}
    </span>
</x-buttons.default>
