<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['url', 'thumbnail_url'];

    public static function add($params) {
    	$file = $params->storeAs('covers', $params->getClientOriginalName());

        return self::firstOrCreate(array('url' => $file, 'thumbnail_url' => $file));
    }

     public function items() {
        return $this->belongsToMany('App\Item', 'items_images', 'image_id', 'item_id');
    }
}
