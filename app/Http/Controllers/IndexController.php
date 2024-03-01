<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class IndexController extends Controller
{
    public function index(): \Illuminate\Contracts\Foundation\Application|Factory|View|Application|\Illuminate\View\View
    {
        return view('index');
    }
}
