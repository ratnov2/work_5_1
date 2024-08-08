<?php

namespace App\Orchid\Filters;

use App\Containers\Item\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ItemFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'market_hash_name',
    ];


    /**
     * @return string
     */
    public function name(): string
    {
        return __('Items');
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('market_hash_name', $this->request->get('market_hash_name'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make('item')
                ->fromModel(Item::class, 'market_hash_name')
                ->empty()
                ->value($this->request->get('market_hash_name'))
                ->title(__('Items')),
        ];
    }
}
