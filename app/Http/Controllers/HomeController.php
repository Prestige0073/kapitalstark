<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $all = require app_path('Data/testimonials.php');
        $testimonials = array_values(array_filter($all, fn($t) => $t['featured']));
        return view('welcome', compact('testimonials'));
    }
}
