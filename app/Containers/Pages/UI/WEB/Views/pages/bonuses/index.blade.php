<div x-data="{
    site_categories: {{ $site_categories_json }},
    swiper: null,
    
    site_categories_filter: {
        has_quests: false
    },

    init() {
        swiper = new Swiper('.swiper', { 
            modules: [SwiperAutoplay, SwiperPagination],
            loop: true, 
            slidesPerView: 1, 
            spaceBetween: 0, 
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
            },
            autoplay: {
                delay: 3000,
                pauseOnMouseEnter: false
            },
        })
    },

    get filtered_site_categories() {
        let site_categories = JSON.parse(JSON.stringify(this.site_categories));

        if(this.site_categories_filter.has_quests) {
            site_categories = site_categories.map(site_category => {
                site_category.sites = site_category.sites.filter(s => s.quests.length > 0);
                return site_category;
            }).filter(site_category => {
                return site_category.sites.length > 0;
            });
        }

        return site_categories;
    }
}" class="flex flex-col space-y-2">
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">
        {{-- Boxes --}}
        <div class="flex flex-col space-y-1 items-center">
            @if(!is_null($box_timer_json) || !is_null($box_promocode_json))
                <div class="grid gap-2 grid-cols-1 md:grid-cols-2 w-full items-start">
                    @if(!is_null($box_timer_json))
                        @component('boxunique::components.box-timer', ['box_json' => $box_timer_json])@endcomponent
                    @endif

                    @if(!is_null($box_promocode_json))
                        @component('boxunique::components.box-promocode', ['box_json' => $box_promocode_json, 'settings_site' => $settings_site])@endcomponent
                    @endif
                </div>
            @else
                <div class="h-48 flex w-full">
                    <x-banners.default title="Стандартные кейсы временно не доступны" desc="Возвращайтесь позже!" color="indigo" />
                </div>
            @endif
            {{-- Link to boxes --}}
            <div class="rounded-md flex space-x-2 items-center text-sm p-1">
                <p class="text-white">Список всех кейсов:</p>

                <a href="#/boxes">
                    <span class="text-indigo-400">Перейти</span>
                </a>
            </div>
        </div>

        {{-- Contests --}}
        <div class="flex flex-col space-y-1 items-center">
            @if(count($contests_json) > 0)
                <div class="grid gap-2 grid-cols-1 md:grid-cols-2 w-full items-start">
                    @foreach ($contests_json as $contest_json)
                        @component('contest::components.contest', ['contest_json' => $contest_json])@endcomponent
                    @endforeach
                </div>
            @else
                <div class="h-48 flex w-full">
                    <x-banners.default class="rounded-md" title="Активных розыгрышей не найдено" desc="В ближайшее время мы активируем новые розыгрыши, возвращайтесь!" color="indigo" />
                </div>
            @endif
            {{-- Link to contests --}}
            <div class="rounded-md flex space-x-2 items-center text-sm p-1">
                <p class="text-white">Список всех розыгрышей:</p>
                <a href="#/contests">
                    <span class="text-indigo-400">Перейти</span>
                </a>
            </div>
        </div>
    </div>

    @if (strlen($bonus_html) != 0)
        <div class="flex gap-2 items-start justify-center">
            {!! $bonus_html !!}
        </div>
    @endif

    {{-- Main --}}
    <div class="grid grid-cols-1 lg:grid-cols-6 gap-2">
        {{-- Left banners --}}
        <div class="col-span-1 hidden lg:block">
            @if(count($left_banners_html) > 0)
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($left_banners_html as $html)      
                            <div class="swiper-slide rounded-lg overflow-hidden">
                                {!! $html !!}
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @endif
        </div>
        {{-- Middle --}}
        <div class="col-span-1 lg:col-span-4">
            {{-- Top banners --}}
            @if(count($top_banners_html) > 0)
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($top_banners_html as $html)      
                            <div class="swiper-slide rounded-lg overflow-hidden">
                                {!! $html !!}
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @endif

            {{-- Site Categories nav --}}
            <div class="mt-2">
                <div class="flex h-16 bg-gray-800 bg-opacity-50 px-2">
                    <div class="flex items-center space-x-1 mx-auto h-full overflow-x-auto overflow-y-hidden">
                        <div class="inline-flex flex-col items-start">
                            <span class="uppercase text-gray-100 mr-4 text-lg whitespace-nowrap">ВЫБЕРИТЕ КАТЕГОРИЮ:</span>

                            <span class="inline-flex items-center space-x-1">
                                <button @click="site_categories_filter.has_quests = !site_categories_filter.has_quests" class="w-5 h-5 rounded border" :class="site_categories_filter.has_quests ? 'border-green-400 bg-green-500' : 'border-gray-600 bg-gray-700'"></button>
                                <span class="text-sm text-gray-500">есть задания</span>
                            </span>
                        </div>

                        <template x-for="site_category in site_categories" :key="site_category.id">
                            <a class="group h-full relative bg-gray-800 hover:bg-gray-700 transition duration-300 px-4 flex items-center justify-center hover:no-underline" href="javascript:;" @click="smoothScroll(`category-${site_category.id}`)">
                                <span class="text-gray-500 group-hover:text-orange-300 transition duration-300 transform text-lg whitespace-nowrap" x-text="site_category.name"></span>
                                <div class="h-0.5 w-full bg-gray-600 absolute bottom-0">
                                    <div class="w-0 h-full absolute left-0 bg-orange-300 group-hover:w-full transition-width duration-300"></div>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>                
            </div>

            {{-- Sites --}}
            <template x-for="site_category in filtered_site_categories" :key="site_category.id">
                <div class="my-5 md:my-10 flex flex-col w-full items-center space-y-2" :id="`category-${site_category.id}`">
                    <div class="flex flex-col items-center justify-center relative w-full">
                        <p class="border-b-2 border-indigo-300 z-10">
                            <span class="text-white text-3xl" x-text="site_category.name"></span>
                        </p>

                        <div class="flex h-0.5 bg-gray-600 w-full opacity-10 absolute z-0 bottom-0"></div>
                    </div>
    
                    <div class="w-full grid justify-center grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <template x-for="site in site_category.sites" :key="site.id">
                            <div class="mb-2 mx-1">
                                <x-site::card site-json="site"/>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
        {{-- Right banners --}}
        <div class="hidden col-span-1 lg:block">
            @if(count($right_banners_html) > 0)
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($right_banners_html as $html)      
                            <div class="swiper-slide rounded-lg overflow-hidden">
                                {!! $html !!}
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @endif
        </div>
    </div>
</div>
