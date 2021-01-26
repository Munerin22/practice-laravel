<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //入力をOKなカラム
	protected $fillable = ['name', 'explain', 'price', 'stock'];
}
