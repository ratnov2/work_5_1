@extends('adsection.profile::layout._page')

@section('page')
    <div class="col-12">
        <div class="card mb-3" x-data="VkGroups()">
            <div class="card-header pb-0 d-flex justify-content-between">
                <h6>Мои группы</h6>
                <form method="POST" action="{{route('ad.vk.groups.connect')}}">
                    @csrf
                    <template x-for="id in selected_group_ids">
                        <input type="hidden" :value="id" name="group_ids[]">
                    </template>
                    <button class="btn mb-0" :class="selected_group_ids.length > 0 ? 'bg-gradient-success' : 'bg-gradient-dark'" :disabled="selected_group_ids.length == 0" type="submit">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                        &nbsp;&nbsp;Подключить
                    </button>
                </form>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                @component('adsection.profile::components.vk-groups-table')
                    @foreach ($connected_groups as $group)
                        @component('adsection.profile::components.vk-group-tr', [
                            'id' => $group->vk_id,
                            'name' => $group->name,
                            'short_name' => $group->vk_short_name,
                            'image' => $group->image,
                            'is_connected' => true
                        ])@endcomponent
                    @endforeach

                    @foreach ($unconnected_groups as $group)
                        @component('adsection.profile::components.vk-group-tr', [
                            'id' => $group['id'],
                            'name' => $group['name'],
                            'short_name' => $group['screen_name'],
                            'image' => $group['photo_50'],
                            'is_connected' => false
                        ])@endcomponent
                    @endforeach
                @endcomponent
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('VkGroups', () => ({
                selected_group_ids: [],
            }));
        })
    </script>
@endsection
