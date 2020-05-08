<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;

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
        $validatedData = $request->validated();
        $item = Item::where('id', $validatedData['id'])->get()->first();
        $item->update($validatedData);

        $itemType = ItemType::where('id', $validatedData['item_type_id'])->first();
        $itemType->items()->save($item);

        if (!empty($params['images'])) {
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
        
        // TODO IMAGES

        return view('edit', compact('item'));
    }

    public static function save($params) {
        if (!empty($params['images'])) {
            $images = $params['images'];
            unset($params['images']);
        }
        $item = Item::add($params);

        // ItemType
        $itemType = ItemType::where('id', $params['item_type_id'])->first();
        $itemType->items()->save($item);

        // Images
        if (!empty($images)) {
            $image = Image::add($images);
            $image->items()->save($item);
        }
        
        return ['result' => 'successfull'];
    }

    public function listSystems() {
        $systems = array();

        $items = Item::with('images')->where('item_type_id', '1')->get();

        foreach($items as $item) {
            $systems->push($item);
            $components = $item->components;
            $systems[$item]['components'] = array();

            foreach($components as $component) {
                $systems[$item]['components']->push($component);
                $elements = $component->elements;
                $systems[$item][$component]['elements'] = array();

                foreach($elements as $element) {
                    $systems[$item][$component]['elements']->push($element);                    
                }
            }
        }

        return view('systems_list', compact('systems'));
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