<?php

namespace App;

use Intervention\Image\Facades\Image as Images;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['url', 'thumbnail_url'];

    public static function add($params) {

    	$origFileName = $params->getClientOriginalName();
    	$file = $params->storeAs('covers', $origFileName);

    	$filePath = Storage::path($file);

    	$thumb = Images::make($filePath)->fit(120)->encode();
		$store = Storage::put('thumbnails/'.$origFileName, $thumb->__toString());

        return self::firstOrCreate(array('url' => 'covers/'.$origFileName, 'thumbnail_url' => 'thumbnails/'.$origFileName));
    }

     public function items() {
        return $this->belongsToMany('App\Item', 'items_images', 'image_id', 'item_id');
    }
}
