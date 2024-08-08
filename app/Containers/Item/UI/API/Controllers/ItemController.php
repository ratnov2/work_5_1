<?php

namespace App\Containers\Item\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\Item\Models\Item;
use App\Containers\Item\UI\API\Resources\ItemResource;
use App\Containers\Item\UI\API\Requests\LoadItemsRequest;

class ItemController extends Controller
{
    public function items(LoadItemsRequest $request) {
        try {
            $params = $request->validated();

            $query = Item::query();

            if(isset($params['price'])) $query->where('price', '<=', $params['price']);

            if(isset($params['rarities'])) $query = $query->whereIn('rarity', $params['rarities']);

            if(isset($params['name'])) {
                $name = trim($params['name']);
                $query = $query->where(function($query2) use($name) {
                    return $query2->where('market_hash_name', 'LIKE', "%$name%")->orWhere('ru_market_hash_name', 'LIKE', "%$name%");
                });
            }

            $items = $query->skip($params['offset'])
                ->limit($params['limit'])
                ->orderBy('price', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'items' => ItemResource::collection($items)
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Ошибка загрузки предметов'
            ]);
        }
    }
}
