<div x-data="progressLine()" class="w-full">
    <div class="bg-gray-800 h-2 rounded-lg stripes animated reverse slower">
        <span class="progress-bar-inner block h-2 rounded-lg bg-indigo-400 relative" :style="{width: progress + '%'}"></span>
    </div>
</div>
