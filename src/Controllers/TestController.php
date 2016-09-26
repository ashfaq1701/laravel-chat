<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
	public function test()
	{
		return view('tests.test');
	}
}