<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['url', 'thumbnail_url'];

    public static function add($params) {
        return self::firstOrCreate(array('url' => $params->url, 'thumbnail_url' => $params->thumbnail_url));
    }

     public function items() {
        return $this->belongsToMany('App\Item', 'items_images', 'image_id', 'item_id');
    }
}
