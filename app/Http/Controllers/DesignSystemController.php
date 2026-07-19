<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignSystemController extends Controller
{
    public function index()
    {
        return view('design_system.showcase');
    }
}
