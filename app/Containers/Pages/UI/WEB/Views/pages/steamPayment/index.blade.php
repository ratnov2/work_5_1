<div class="lg:mx-auto lg:container text-gray-200">
    <div class="text-center my-3">
        <h2 class="text-3xl text-gray-100 ">КАК ПОПОЛНИТЬ STEAM ДЛЯ CS:GO В 2023 НА ЛЮБУЮ СУММУ</h2>
    </div>

    <p class="mb-2">Как пополнить Steam аккаунт в 2023 для CS:GO</p>
    <p class="mb-2">Сейчас многие пользователи из России столкнулись с тем что они не могут пополнить стим аккаунт для покупки игр внутри площадки стим либо для покупки скинов для игры в CS:GO, следуя простой инструкции ты можешь легко в течении 5 минут сделать депозит в стим!</p>

    <ol class="list-decimal space-y-5 xl:space-y-10" style="padding: 0 16px">
        <li>
            <h3>Войти через Steam</h3>
            <p>Войдите используя свой аккаунт Steam</p>
            <img class="w-full" src="{{asset('img/steamPayment/1.png')}}" alt="login via steam">
        </li>

        <li>
            <h3>Пополнить баланс</h3>
            <p>Внеси деньги любым из доступных методом на сайт {{Request::getHttpHost()}} (QIWI, карты любых банков, сбербанк онлайн, криптовалюта и многие другие)</p>
            <img class="w-full" src="{{asset('img/steamPayment/2.png')}}" alt="payment">
        </li>

        <li>
            <h3>Купите любой предмет в нашем магазине скинов</h3>

            <div class="flex flex-wrap w-full mx-auto space-x-2">
                <img src="{{asset('img/steamPayment/3.2.png')}}" alt="shop">
                <img src="{{asset('img/steamPayment/3.1.png')}}" alt="shop">
            </div>
        </li>

        <li>
            <h3>Запросить вывод в Steam</h3>
            <p>Запроси выигранные скины CS GO к себе на стим аккаунт и подтверди его получение</p>
            <p>После чего можешь его продать и получить деньги на свой стим аккаунт!</p>
            <img class="w-full" src="{{asset('img/steamPayment/4.png')}}" alt="withdraw">
        </li>
    </ol>

    <x-banners.default class="rounded my-5" color="green" title="Готово!" desc="Теперь ты знаешь как пополнять свой Steam аккаунт!" />
</div>
