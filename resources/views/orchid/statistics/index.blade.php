@foreach ($groups_statistics_cards as $title => $statistics_cards)
    <div class="mb-3">
        <h3 class="mb-1 text-md">{{$title}}</h3>
        <div class="grid gap-3 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($statistics_cards as $statistics_card)
                <div class="rounded-lg shadow-md p-3 bg-white">
                    <p>{{$statistics_card['title']}}</p>
                    <div class="">
                        <span class="text-xl font-bol">{{$statistics_card['value']}}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach
