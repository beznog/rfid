<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Item;
use App\ItemType;
use App\Image;

use App\Http\Requests\CreateItemRequest;

use Illuminate\Database\Eloquent\Builder;

class ItemController extends Controller
{
    public function index()
    {
        return view('start_screen');
    }

    public static function list()
    {
        $items = self::getAllItems();
        return view('list', compact('items'));
    }

    public static function store(CreateItemRequest $request)
    {
    	$validatedData = $request->validated();
        return self::save($validatedData);
    }

    public function edit(CreateItemRequest $request) {
        // TODO
        $validatedData = $request->validated();

        $item = Item::where('id', $params['item_id'])->get()->first();
        $item->update($validatedData);

        $itemType = ItemType::where('item_type', $validatedData['item_type'])->first();
        $itemType->items()->save($item);

        if (!empty($params['pictuimagesre'])) {
            // TODO
        }

        return ['result' => 'successfull'];
    }

    public static function delete($itemId) {
        Item::find($itemId)->delete();
        return ['result' => 'successfull'];
    }

    public function autocompleteEditForm($itemId)
    {
        $item = Item::where('id', $itemId)->get()->first()->getInTextForm();
        $illustrations = Arr::where($illustrations, function ($value, $key) use ($item) {
            return $item['images'][0]['url']!=$value['url'];
        });
        if(empty($item['images'])) {
            $item['images'] = array();
        }
        $item['images'] = array_merge($item['images'], $illustrations);

        return view('edit', compact('item'));
    }

    public static function save($params) {
        $item = Item::add($params);

        // ItemType
        $itemType = ItemType::where('item_type', $params['item_type'])->first();
        $itemType->items()->save($item);

        // Images
        if (!empty($params['images'])) {
            // TODO
        }
        
        return ['result' => 'successfull'];
    }    

    public static function getAllItems() {
        return Item::with('images')->get();
    }

    public function getAllSystems() {
        $itemType = ItemType::where('item_type', 'system')->first();
        return $itemType->items;
    }

    public function getAllComponents() {
        $itemType = ItemType::where('item_type', 'component')->first();
        return $itemType->items;
    }

    public function getAllElements() {
        $itemType = ItemType::where('item_type', 'element')->first();
        return $itemType->items;
    }

    public function getItemById($itemId) {
        return Item::where('id', $itemId)->get()->first();
    }

    public function getItemByTagId($tagId) {
        return Item::where('tag_id', $tagId)->get()->first();
    }
}