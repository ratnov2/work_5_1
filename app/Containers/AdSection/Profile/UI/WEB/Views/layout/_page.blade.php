@extends('adsection.profile::layout._index')

@section('sidebar')
    @include('adsection.profile::layout.sidebar')
@endsection

@section('content')
    <div class="container-fluid mb-5">
        <div class="page-header min-height-150 border-radius-xl mt-4">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
            <div class="row col-auto">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{$user->image}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-0">
                            {{$user->name}}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            Рекламодатель
                        </p>
                        <p class="mb-0 text-xs">
                            Баланс: {{$user->balance}} РУБ.
                        </p>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <a href="{{route('ad.auth.logout')}}" class="btn bg-gradient-primary mb-0">Выйти</a>
                </div>
            </div>
        </div>
    </div>

    @yield('page')
@endsection
