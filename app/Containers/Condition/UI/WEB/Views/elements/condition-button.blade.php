<template x-if="{{$alpine__condition}} && {{$alpine__condition}}.action != null">
    <div x-data="{ is_open: false }" class="w-full flex justify-center">
        <button @click="is_open = true" class="inline-flex text-gray-100 text-xs underline decoration-dashed">Просмотреть условия</button>
        
        <x-modal is-open="is_open">
            @include('condition::elements.condition-list')
        </x-modal>
    </div>
</template>
