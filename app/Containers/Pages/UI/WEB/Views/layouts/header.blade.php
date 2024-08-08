<header class="bg-gray-900 flex flex-col shadow-md" x-data="{ is_open: false }">
    {{-- Mobile statistics --}}
    <template x-if="window.screen.width < 1024">
        <div class="flex w-full p-2 bg-gray-900">
            @include('statistics::components.statistics')
        </div>
    </template>

    {{-- Live drops --}}
    <div class="w-full border-b border-gray-1000">
        @include('livedrops::components.live-drops')
    </div>

    {{-- Top panel --}}
    <div class="flex flex-col items-center justify-center w-full px-2 py-4 lg:px-7">
        <div class="w-full flex items-center">
            {{-- Desktop --}}
            <div class="justify-start flex-grow flex space-x-10">
                @include('pages::elements.logo')

                <template x-if="window.screen.width >= 1024">
                    <div class="flex w-2/4">@include('statistics::components.statistics')</div>
                </template>
            </div>

            {{-- Desktop menu --}}
            <div class="hidden xl:flex justify-end space-x-10 items-center">
                @include('pages::layouts.menu.social')
                <template x-if="window.screen.width >= 1280">
                    @include('pages::layouts.menu.profile')
                </template>
            </div>

            {{-- Mobile menu button --}}
            <div class="flex xl:hidden justify-end">
                <button class="text-gray-100 text-xl" @click="is_open = !is_open"><i class="fas fa-bars"></i></button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="is_open" x-collapse class="xl:hidden flex flex-col items-center justify-center w-full mt-5 space-y-2">
            <template x-if="window.screen.width < 1280">
                @include('pages::layouts.menu.profile')
            </template>
            @include('pages::layouts.menu.social')
        </div>
    </div>

    {{-- Bottom panel --}}
    <div class="flex justify-start w-full px-2 lg:px-7 min-h-[72px]">
        @include('pages::layouts.menu.nav')
    </div>
</header>
