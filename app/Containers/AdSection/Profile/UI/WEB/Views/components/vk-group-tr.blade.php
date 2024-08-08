<tr>
    <td>
        <div class="d-flex px-2 py-1">
            <div>
                <img src="{{ $image }}" class="avatar avatar-sm me-3" alt="group_img">
            </div>
            <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm">{{ $name }}</h6>
                <p class="text-xs text-secondary mb-0">{{ $short_name }}</p>
            </div>
        </div>
    </td>
    <td class="align-middle text-center text-sm">
        @if ($is_connected)
            <span class="badge badge-sm bg-gradient-success">Подключено</span>
        @else
            <span class="badge badge-sm bg-gradient-secondary">Не подключено</span>
        @endif
    </td>
    <td class="align-middle text-center">
        @if ($is_connected)
            <form method="POST" action="{{route('ad.vk.groups.connect')}}">
                @csrf
                <input type="hidden" value="{{$id}}" name="group_ids[]">
                <button type="submit" class="btn bg-gradient-info mb-0"><i class="fas fa-redo"></i></button>
            </form>
        @else
            <div class="d-inline-flex form-check form-switch ps-0">
                <input class="form-check-input ms-auto" x-model="selected_group_ids" value="{{$id}}" type="checkbox">
            </div>
        @endif
    </td>
</tr>
