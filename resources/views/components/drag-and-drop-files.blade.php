@props([
    'types',
    'onFileUploaded'
])

<div {{$attributes->class([
    'rounded-lg', 
    'border', 
    'border-gray-500', 
    'border-dashed', 
    'p-3',
])}}
    x-data="dragAndDropFilesData({{$types}})" 
    x-on:drop="dropHandler(event)" 
    x-on:dragenter="dragEnterHandler(event)"
    x-on:dragover="dragOverHandler(event)"
    @file-uploaded="{{$onFileUploaded}}($event.detail)" 
>
    {{ $slot }}
</div>