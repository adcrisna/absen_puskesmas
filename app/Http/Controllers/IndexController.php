<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $title = 'Selamat Datang';
        return view('index', compact('title'));
    }
    public function about() {
        $title = 'Tentang Kami';
        return view('about', compact('title'));
    }
}
