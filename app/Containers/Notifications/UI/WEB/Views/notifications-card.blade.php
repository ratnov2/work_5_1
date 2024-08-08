@php
    $notifications = collect(Auth::guard('players')->user()->unreadNotifications)->take(5);
@endphp
<div x-data="notificationsCardData()" class="relative flex justify-center" @click.away="is_open = false">
    <button @click="is_open = !is_open" class="text-indigo-400 text-lg"><i class="fas fa-bell"></i></button>

    <div x-show="is_open" @click.stop x-collapse :class="{'opacity-100' : is_open, 'opacity-0' : !is_open}" class="w-96 transition-all duration-300 p-4 rounded-lg shadow-lg absolute z-30 bg-gray-700 -left-10 md:left-auto md:right-0 top-10">
        @if (count($notifications) > 0)
            <ul>
                @foreach ($notifications as $notification)
                    <li>
                        <div class="w-full p-3 mt-6 bg-gray-800 bg-opacity-70 rounded-lg flex">
                            <div tabindex="0" aria-label="post icon" role="img" class="flex-shrink-0 text-indigo-400 focus:outline-none w-8 h-8 border rounded-full border-gray-700 flex items-center justify-center">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="pl-3">
                                <p tabindex="0" class="focus:outline-none text-sm leading-none text-white">
                                    {!! $notification->data['msg']  !!}
                                </p>
                                <p tabindex="0" class="focus:outline-none text-xs leading-3 pt-1 text-gray-500">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->setTimezone('Europe/Moscow')->format('Y-m-d H:i:s')}}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="flex space-x-2">
                <span class="text-2xl text-gray-400">
                    <i class="fad fa-comment-slash"></i>
                </span>
                <p class="text-sm text-gray-400">У вас пока нет новых уведомлений. История уже прочитаных сообщений доступна по ссылке ниже.</p>
            </div>
        @endif
        <div class="p-3 bg-indigo-400 w-full mt-5 rounded-lg flex justify-center items-center">
            <a class="text-white text-sm" href="#/notifications">Просмотреть историю уведомлений</a>
        </div>
    </div>
</div>
