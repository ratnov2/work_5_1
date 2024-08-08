<div class="w-full bg-gray-800 p-4 rounded">
    <div class="flex items-center justify-between">
        <p class="focus:outline-none text-2xl font-semibold leading-6 text-gray-100">Уведомления</p>
    </div>
    @foreach ($notifications as $date => $date_notifications)
        <h2 class="focus:outline-none text-sm leading-normal pt-8 border-b pb-2 border-gray-600 text-gray-400">{{$date}}</h2>
        @foreach ($date_notifications as $notification)
            <div class="w-full p-3 mt-6 bg-gray-700 rounded-lg flex">
                <div  aria-label="post icon" role="img" class="text-indigo-400 focus:outline-none w-8 h-8 border rounded-full border-gray-700 flex items-center justify-center">
                    <i class="fas fa-comment"></i>
                </div>
                <div class="pl-3">
                    <p  class="focus:outline-none text-sm leading-none text-gray-100">
                        {!! $notification->data['msg']  !!}
                    </p>
                    <p  class="focus:outline-none text-xs leading-3 pt-1 text-gray-500">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->setTimezone('Europe/Moscow')->format('H:i:s')}}</p>
                </div>
            </div>
        @endforeach
    @endforeach
</div>
