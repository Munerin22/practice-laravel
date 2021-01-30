<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    //入力をOKなカラム
	protected $fillable = ['name', 'explain', 'price', 'stock'];

	//リレーション
	public function cart() {
		return $this->hasOne('App\Cart');
	}

	//ソフトデリート
	use SoftDeletes;
	protected $dates = ['deleted_at'];

}
