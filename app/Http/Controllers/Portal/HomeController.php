<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;

class HomeController extends Controller
{
    public function index()
    {
        $jenisSurat = JenisSurat::orderBy('label')->get();

        return view('portal.pages.home', compact('jenisSurat'));
    }
}
