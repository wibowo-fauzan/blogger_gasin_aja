<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserHomeScreenController extends Controller
{
    public function index() {
        return view('welcome');
    }
}
