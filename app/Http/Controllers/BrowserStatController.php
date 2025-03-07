<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrowserStat;

class BrowserStatController extends Controller
{
    public function index()
    {
        $browserStats = BrowserStat::all();
        $labels = $browserStats->pluck('browser_name');
        $data = $browserStats->pluck('visit_count');

        return view('browser-stats', compact('labels', 'data'));
    }
}
