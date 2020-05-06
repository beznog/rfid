<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Item;
use App\ItemType;
use App\Image;

use App\Services\CreateItemService;
use App\Services\EditItemService;
use App\Services\DeleteItemService;
use App\Services\GetItemService;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\GetItemRequest;

use Illuminate\Database\Eloquent\Builder;

class ItemController extends Controller
{
    public function index()
    {
        return view('start_screen');
    }

    public function list()
    {
        $items = Item::with('images')->get();
        return view('list', compact('items'));
    }

    public function store(CreateItemRequest $request)
    {
        return CreateItemService::store($request);
    }

    public function edit(CreateItemRequest $request) {
        return EditItemService::edit($request);
    }

    public function delete($itemId) {
        return DeleteItemService::softDelete($wordId);
    }
}