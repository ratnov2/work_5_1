<div class="flex items-center justify-center relative w-full h-full">
    <svg class="w-full h-full" viewbox="0 0 42 42">
        @foreach ($svg_circle_segments as $svg_circle_segment)
            <circle data-circle-id="{{$svg_circle_segment['id']}}" cx="21" cy="21" r="15.91549430918954" fill="transparent"
                stroke-width="1"
                stroke="{{$svg_circle_segment['stroke']}}"
                stroke-dasharray="{{$svg_circle_segment['stroke-dasharray']}}"
                stroke-dashoffset="{{$svg_circle_segment['stroke-dashoffset']}}"
            >
            </circle>
        @endforeach
    </svg>
    @foreach ($players_info_with_coordinate as $player_info_with_coordinate)
        <span data-avatar-id="{{$player_info_with_coordinate['player']['id']}}" class="absolute z-20 w-10 h-10 border rounded flex items-center justify-center"
            style="border-color:{{$player_info_with_coordinate['color']}}; transform: translate({{$player_info_with_coordinate['coordinate']['x']}}px, {{$player_info_with_coordinate['coordinate']['y']}}px)">
            {{$player_info_with_coordinate['player']['name']}}
        </span>
    @endforeach
</div>


