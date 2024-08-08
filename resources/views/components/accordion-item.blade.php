@props(['index', 'title'])

<li class="relative">
    <button type="button" class="w-full px-6 py-3 text-left bg-gray-700 rounded"
        @click="selected !== {{ $index }} ? selected = {{ $index }} : selected = null">
        <div class="flex items-center justify-start space-x-2">
            <i class="fas fa-plus-circle"></i>
            <span x-text="{{ $title }}"></span>
        </div>
    </button>

    <div class="relative overflow-hidden transition-all max-h-0 duration-700 bg-gray-800"
        x-ref="container{{ $index }}"
        :style="selected == {{ $index }} ? 'max-height: ' + $refs.container{{ $index }}.scrollHeight + 'px' : ''">
        <div class="p-3">
            {{ $slot }}
        </div>
    </div>
</li>
