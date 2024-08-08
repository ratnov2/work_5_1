@if (session()->has('messages'))
    @php $messages = session()->get('messages'); @endphp
    @foreach ($messages as $message)
        <script>toast('info', {!! json_encode($message) !!})</script>
    @endforeach
@endif

@if (session()->has('msg') && session()->has('status'))
    @php $status = session()->get('status'); $msg = session()->get('msg'); @endphp
    @if ($status == 'error')
        <script>toast('error', {!! json_encode($msg) !!})</script>
    @elseif ($status == 'success')
        <script>toast('success', {!! json_encode($msg) !!})</script>
    @endif
@endif

@if (!session()->has('msg') && session()->has('status'))
    @php $status = session()->get('status');@endphp
    <script>toast('success', {!! json_encode($status) !!})</script>
@endif
