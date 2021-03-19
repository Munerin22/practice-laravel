<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addressee extends Model
{
	//入力OKなカラム
	protected $fillable = ['user_id', 'name', 'post_number', 'prefecture', 'city', 'below_address', 'phone',];

	//リレーション
	public function user() {
		return $this->hasOne('App\User');
	}

	//ソフトデリート
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
