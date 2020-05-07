<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Item;
use App\ItemType;


class ItemTypeController extends Controller
{
    public static function list()
    {
        $itemTypes = self::getAllItemTypes();
        return view('list', compact('itemTypes'));
    }  

    public static function getAllItemTypes() {
        return ItemType::all()->pluck('item_type')->all();
    }
}
