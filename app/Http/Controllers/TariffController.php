<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tariff;

class TariffController extends Controller
{
    // Тарифы на главной странице
    public function index()
    {
        $tariffs = Tariff::all();
        return view('index', compact('tariffs'));
    }
}
