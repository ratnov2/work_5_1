<?php

namespace App\Orchid\Screens\SiteCategory;

use App\Containers\Site\Models\SiteCategory;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class SiteCategoryEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(SiteCategory $category): array
    {
        $this->exists = $category->exists;

        if ($this->exists) $this->name = 'Редактирование';

        return [
            'category' => $category
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Создать')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('update')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $site_categories = SiteCategory::get();

        $positions = $site_categories->pluck('position');
        $positions->push($site_categories->count() + 1);

        $options = [];
        foreach ($positions as $position)
            $options[$position] = $position;

        return [
            Layout::rows([
                Select::make('category.position')
                    ->options($options)
                    ->empty('Не выбрано')
                    ->title('Позиция')
                    ->help('Позиция, на которой будет находиться категория')
                    ->required(),

                Input::make('category.name')
                    ->title('Имя')
                    ->required()

            ])
        ];
    }

    public function create(SiteCategory $category, Request $request)
    {
        DB::transaction(function () use ($category, $request) {
            $params = $request->get('category');

            SiteCategory::where('position', '>=', $params['position'])->orderBy('position', 'desc')->increment('position');

            $category->fill($params);
            $category->save();

            Alert::info('Успешное создание категории');

            return redirect()->route('platform.site-category.list');
        });
    }

    public function update(SiteCategory $category, Request $request)
    {
        DB::transaction(function () use ($category, $request) {
            $params = $request->get('category');

            $category->position < $params['position']
                ? SiteCategory::where([['position', '<=', $params['position']], ['position', '>', $category->position]])->decrement('position')
                : SiteCategory::where([['position', '>=', $params['position']], ['position', '<', $category->position]])->increment('position');

            $category->fill($params);
            $category->save();

            Alert::info('Успешное обновление категории');

            return redirect()->route('platform.site-category.list');
        });
    }

    public function remove(SiteCategory $category)
    {
        DB::transaction(function () use ($category) {
            $category->delete();
            SiteCategory::where('position', '>', $category->position)->decrement('position');

            Alert::info('Категория успешно удалена');

            return redirect()->route('platform.site.list');
        });
    }
}
