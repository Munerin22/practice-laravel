<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    //リレーション
	public function item() {
		return $this->belongsTo('App\Item', 'item_id');
	}

	//ソフトデリート
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
