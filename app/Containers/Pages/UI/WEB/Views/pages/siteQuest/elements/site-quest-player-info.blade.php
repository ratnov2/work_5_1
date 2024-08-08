<div class="flex flex-col space-y-3">
    <textarea class="rounded-lg border-gray-500 border w-full p-2 focus:outline-none placeholder:text-sm placeholder:text-gray-500" placeholder="Укажите дополнительную информацию, которую требует задание..." style="background: none;" name="text" rows="7"></textarea>

    {{-- Input images --}}
    <div class="flex flex-col">
        <x-drag-and-drop-files class="w-full h-44 flex justify-center items-center" types="['image/jpeg', 'image/png']" on-file-uploaded="dragAndDropFileUploaded">
            <p x-show="loaded_images.length == 0">Переместите файлы <i>сюда</i>.</p>
            
            <div x-show="loaded_images.length != 0" class="h-full w-full overflow-y-hidden overflow-x-auto flex flex-start">
                <template x-for="(image, index) in loaded_images" :key="'image' + index">
                    <div class="flex w-fit relative">
                        <button type="button" @click="removeImage(image)" class="absolute z-10 top-0 right-0 rounded-full bg-red-500 text-white inline-flex justify-center items-center w-5 h-5">-</button>
                        <img class="object-contain w-40 h-40 mx-0.5" :src="image" alt="image">
                        <input type="hidden" name="images[]" :value="image" />
                    </div>
                </template>
            </div>
        </x-drag-and-drop-files>

        <input class="my-2" type="file" @change="fileInputChange(event); this.files = []" multiple />

        <small class="text-red-400 text-xs"><i>Не более 3 скриншотов, допустимые форматы: JPEG, PNG</i></small>
    </div>
</div>