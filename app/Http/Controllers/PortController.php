<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Port;

class PortController extends Controller
{
    //
	public function menu() {
			session()->flush();
			$ports = Port::all()->sortByDesc('id');
			return view('welcome', compact('ports'));
	}
}
