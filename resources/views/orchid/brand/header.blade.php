@php $domain = explode('.', request()->getHttpHost());@endphp
<span class="uppercase text-3xl font-bold">
    <span>{{$domain[count($domain) - 2]}}<span>.{{$domain[count($domain) - 1]}}</span></span>
</span>
