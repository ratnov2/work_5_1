<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 d-flex"
    id="sidenav-main">
    <div class="sidenav-header">
        <a class="navbar-brand m-0" href="{{ route('ad.profile.index') }}" target="_blank">
            <span class="ms-1 font-weight-bold">ГРИБ-FREE | Реклама</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @php
                $routes = [
                    ['title' => 'Главная', 'name' => 'ad.profile.index', 'icon' => '<i class="fas fa-home"></i>'],
                    ['title' => 'Мои группы VK', 'name' => 'ad.profile.vk.groups', 'icon' => '<i class="fab fa-vk"></i>'],
                ];
            @endphp
            @foreach ($routes as $route)
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == $route['name'] ? 'active' : '' }}"href="{{ route($route['name']) }}">
                        {!! $route['icon'] !!}
                        <span class="nav-link-text ms-1">{{ $route['title'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="sidenav-footer mx-3 mt-auto">
        <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
            <div class="full-background" style="background-image: url({{asset('/vendor/ad/img/curved-images/white-curved.jpg')}})"></div>
            <div class="card-body text-start p-3 w-100">
                <div class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                    <i class="ni ni-diamond text-dark text-gradient text-lg top-0" aria-hidden="true" id="sidenavCardIcon"></i>
                </div>
                <div class="docs-info">
                    <h6 class="text-white up mb-0">Остались вопросы?</h6>
                    <p class="text-xs font-weight-bold">Свяжитесь с администратором группы</p>
                    <a href="https://vk.com/grib_free" target="_blank"
                        class="btn btn-white btn-sm w-100 mb-0">Перейти</a>
                </div>
            </div>
        </div>
    </div>
</aside>
