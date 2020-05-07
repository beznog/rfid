<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = ['name','item_type_id','description','tag_id'];

    public static function add($params) {
        return self::firstOrCreate($params);
    }
    
    public function getInTextForm()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => (!empty($this->description)) ? $this->description : null,
            'itemTypeId' => $this->item_type_id,
            'tagId' => (!empty($this->tag_id)) ? $this->tag_id : null,
            'images' => (!empty($this->images->first())) ? array(
                array(
                    'url' => $this->images->first()['url'],
                    'thumbnail_url' => $this->images->first()['thumbnail_url']
                )
            ) : null
        ];
    }

    public function itemTypes() {
        return $this->belongsTo('App\ItemType', 'item_type_id');
    }

    public function images() {
        return $this->belongsToMany('App\Image', 'items_images', 'item_id', 'image_id');
    }

    public function components() {
        return $this->belongsToMany('App\Item', 'systems_components', 'system_id', 'component_id');
    }

    public function elements() {
        return $this->belongsToMany('App\Item', 'components_elements', 'component_id', 'element_id');
    }

    public function getParentComponent() {
        // TODO
    }

    public function getParentSystem() {
        // TODO
    }
}
