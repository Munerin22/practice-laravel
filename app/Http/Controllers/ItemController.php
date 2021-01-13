<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller {
	public function index() {
		$var = 20210113;
		return view('item.index', compact('var'));
	}
}
