<a href="{{route('spa')}}">
    @if(!is_null($logo))
        <img class="w-[5.5rem]" src="{{asset($logo)}}" alt="logo">
    @else 
        @php $domain = explode('.', request()->getHttpHost());@endphp
        <span class="text-orange-300 uppercase font-bold text-2xl">{{$domain[count($domain) - 2]}}<span class="text-white uppercase font-bold">.{{$domain[count($domain) - 1]}}</span></span>
    @endif
</a>