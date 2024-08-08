<?php

namespace App\Orchid\Screens\Banner;

use App\Containers\Banner\Models\Banner;
use App\Orchid\Layouts\Banner\BannerListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;

class BannerListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Баннеры';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все баннеры';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'banners' => Banner::paginate(10)
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Создать баннер')
                ->icon('pencil')
                ->route('platform.banner.edit')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            BannerListLayout::class
        ];
    }

     /**
     * @param Request $request
     */
    public function toggleSwitchers(Request $request): void
    {
        $banner = Banner::findOrFail($request->get('id'));
        $key = $request->get('key');

        $banner->$key = !$banner->$key;
        $banner->save();

        Toast::info('Успешно');
    }


    public function remove(Banner $banner)
    {
        DB::beginTransaction();
        try {
            $banner->delete();

            DB::commit();
            Toast::info('Баннер был удален');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

}
