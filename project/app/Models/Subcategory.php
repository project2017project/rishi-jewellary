<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = ['category_id','name','slug','photo','is_featured','image','meta_title','meta_keyword','meta_description'];
    public $timestamps = false;

    public function childs()
    {
    	return $this->hasMany('App\Models\Childcategory')->where('status','=',1);
    }

    public function category()
    {
    	return $this->belongsTo('App\Models\Category')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }

       public function products()
    {
		return $this->hasMany('App\Models\Product')->where('status', 1)->where('sum_stock','!=','');        
    }
	public function sproducts()
    {
		return $this->hasMany('App\Models\Product')->where('status', 1)->where('sal_status',1)->where('sum_stock','!=','');
        
    }
	public function bproducts()
    {
		return $this->hasMany('App\Models\Product')->where('status', 1)->where('minPrice','<',1000)->where('sum_stock','!=','');        
    }

   public function vproducts()
    {
		$slug='Anicha';
		$string = str_replace('-',' ', $slug);
        $vendor = User::where('shop_name','=',$string)->firstOrFail();		
		return $this->hasMany('App\Models\Product')->where('status', 1)->where('sum_stock','!=','');
    }
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_replace(' ', '-', $value);
    }

    public function attributes() {
        return $this->morphMany('App\Models\Attribute', 'attributable');
    }

}
