<?php

namespace App\Orchid\Screens\SiteCategory;

use App\Containers\Site\Models\SiteCategory;
use Orchid\Screen\Screen;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;


class SiteCategoryListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Категории';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все категории';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'site_categories' => SiteCategory::paginate(10)
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
            Link::make('Создать категорию')
                ->icon('pencil')
                ->route('platform.site-category.edit')
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
            Layout::table('site_categories', [
                TD::make('id', 'ID')->render(function (SiteCategory $category) {
                    return Link::make($category->id)
                        ->route('platform.site-category.edit', $category);
                    }),
                    
                TD::make('position', 'Позиция'),
    
                TD::make('name', 'Имя')
                    ->render(function (SiteCategory $category) {
                        return Link::make($category->name)
                            ->route('platform.site-category.edit', $category);
                    }),
    
                TD::make('created_at', 'Создан')
                    ->render(function (SiteCategory $category) {
                        return $category->human_created_at;
                    }),
    
                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function (SiteCategory $category) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Редактировать'))
                                    ->icon('pencil')
                                    ->route('platform.site-category.edit', $category->id),
    
                                Button::make(__('Удалить'))
                                    ->icon('trash')
                                    ->confirm('ВНИМАНИЕ! Все ваши сайты ( ' . $category->sites->count() . ' сайт(-ов) ) из данной категории также будут удалены!')
                                    ->method('remove', [
                                        'id' => $category->id,
                                    ]),
                            ]);
                    }),
            ])
        ];
    }


    public function remove(SiteCategory $category)
    {
        DB::transaction(function () use($category) {        
            $category->delete();
            SiteCategory::where('position', '>', $category->position)->decrement('position');

            Toast::info('Категория была удалена');
        });
    }
}
