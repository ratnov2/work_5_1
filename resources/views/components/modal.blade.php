@props([
    'isOpen'
])

<template x-teleport="body">
    <div @click="{{$isOpen}} = false"
        class="p-2 sm:p-5 overflow-y-auto w-full h-full flex justify-center align-center fixed top-0 left-0 bg-gray-1000 bg-opacity-70 backdrop-blur-sm z-40"
        x-show="{{$isOpen}}"
        x-transition
    >
        <div @click.stop class="w-full sm:w-fit min-h-full sm:min-h-fit h-fit flex relative sm:m-auto">
            <button @click="{{$isOpen}} = false" class="text-white absolute top-2 right-4 md:-top-3 md:-right-2 text-2xl z-10"><i class="fas fa-times"></i></button>
            
            {{$slot}}
        </div>
    </div>
</template>