<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CovidDaily;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
    // Data Indonesia
    $today_idn = CovidDaily::where('country', 'Indonesia')
                ->orderBy('date', 'desc')->first();

    // Data Dunia (aggregate)
$today_world = CovidDaily::selectRaw('MAX(date) as date, SUM(confirmed) as confirmed, SUM(deaths) as deaths, SUM(recovered) as recovered, SUM(active) as active')
    ->first();


    // Timeline Indonesia H-30 hingga H-1
    $timeline_idn = CovidDaily::where('iso', 'IDN')
        ->orderBy('date', 'desc')
        ->take(30)
        ->get()
        ->reverse();

    // Timeline Dunia H-30 hingga H-1 (aggregate per date)
$timeline_world = CovidDaily::selectRaw('date, SUM(confirmed) as confirmed, SUM(deaths) as deaths, SUM(recovered) as recovered, SUM(active) as active')
    ->groupBy('date')
    ->orderBy('date', 'desc')
    ->take(30)
    ->get()
    ->reverse();


    // Potensi Kasus Positif Indonesia (contoh definisi)
    $potensi_idn = ($today_idn->active / $today_idn->confirmed) * 100;

    // Potensi Kasus Positif Dunia
    $potensi_world = ($today_world->active / $today_world->confirmed) * 100;

    return view('dashboard', [
        'today_idn' => $today_idn,
        'today_world' => $today_world,
        'timeline_idn' => $timeline_idn,
        'timeline_world' => $timeline_world,
        'potensi_idn' => $potensi_idn,
        'potensi_world' => $potensi_world
    ]);
    }
}
