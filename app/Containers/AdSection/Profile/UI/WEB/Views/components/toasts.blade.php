@if (session()->has('msg') && session()->has('status'))
    @php $status = session()->get('status'); $msg = session()->get('msg'); @endphp

    @if ($status == 'error')
        <script>toastr.error({!! json_encode($msg) !!})</script>
    @elseif ($status == 'success')
        <script>toastr.success({!! json_encode($msg) !!})</script>
    @endif
@endif
