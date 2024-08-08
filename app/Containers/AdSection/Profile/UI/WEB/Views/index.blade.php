@extends('adsection.profile::layout._page')

@section('page')
    <div class="col-12">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-flex flex-column h-100">
                            <p class="mb-1 pt-2 text-bold">Добро пожаловать!</p>
                            <h5 class="font-weight-bolder"> - Что это за платформа?</h5>
                            <p class="mb-1 text-xs">Данная рекламная платформа предназначена для предоставления рекламных услуг и аналитике по сайту {{ Request::getHost() }}</p>
                            <p class="mb-3 text-xs">Платформа находится в активной стадии разработки, все функции по аналитике и рекламе будут реализованы в ближайшее время</p>
                            <h5 class="font-weight-bolder"> - Что я могу сейчас?</h5>
                            <p class="mb-1 text-xs"> - Спонсорские розыгрыши</p>
                            <p class="mb-1 text-xs"> - Спонсорские условия на кейсы</p>
                            <p class="mb-1 text-xs"> - Приобретение рекламных карточек сайтов</p>
                            <p class="mb-1 text-xs"> - Приобретение рекламных баннеров</p>
                            <p class="mb-1 text-xs"> - Подключить ваши группы ВК. Открывается возможность поставить условие на "+ в лс"</p>
                            <p class="mb-1 text-xs">Подробности по стоимости и других услугах уточняйте у наших администраторов</p>
                        </div>
                    </div>
                    <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                        <div class="bg-gradient-primary border-radius-lg h-100">
                            <img src="{{asset('/vendor/ad/img/shapes/waves-white.svg')}}" class="position-absolute h-100 w-50 top-0 d-lg-block d-none" alt="waves">
                            <div class="position-relative d-flex align-items-center justify-content-center h-100">
                                <img class="w-100 position-relative z-index-2 pt-4" src="{{asset('/vendor/ad/img/illustrations/rocket-white.png')}}" alt="rocket">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
