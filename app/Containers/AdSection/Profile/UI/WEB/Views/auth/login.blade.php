@extends('adsection.profile::layout._index')

@section('content')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">ГРИБ-FREE | Реклама</h3>
                                <p class="mb-0">Вход в кабинет рекламодателя</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{route('ad.auth.vk.login')}}">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked="">
                                        <label class="form-check-label" for="remember">Запомнить меня</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Авторизация VK</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                style="background-image:url({{asset('vendor/ad/img/curved-images/curved6.jpg')}})"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

