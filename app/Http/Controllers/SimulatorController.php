<?php

namespace App\Http\Controllers;

class SimulatorController extends Controller
{
    public function index()
    {
        return view('simulateur.index');
    }

    public function compare()
    {
        return view('simulateur.compare');
    }

    public function capacity()
    {
        return view('simulateur.capacity');
    }
}
