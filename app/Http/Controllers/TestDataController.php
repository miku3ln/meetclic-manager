<?php

namespace App\Http\Controllers;

class TestDataController  extends Controller
{
    public function index()
    {
        return view('testData.index'); // Usa layouts.app automáticamente
    }
}
