<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $table = 'item_types';
    protected $fillable = ['item_type'];

    public function items() {
        return $this->hasOne('App\Item', 'item_type_id');
    }
}