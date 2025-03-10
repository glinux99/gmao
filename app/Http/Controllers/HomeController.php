<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $startMon = Carbon::now()->startOfMonth();
        $endMon = Carbon::now()->endOfMonth();
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $startDay = Carbon::now()->startOfDay();
        $endDay = Carbon::now()->endOfDay();
        $categories = Category::all();
        $months=StockHistory::where('type', 'withdraw')->with(['category', 'demandeur'])
        ->whereBetween('created_at', [$startMon, $endMon])
        ->get();
        $weeks=StockHistory::where('type', 'withdraw')->with(['category', 'demandeur'])
        ->whereBetween('created_at', [$startWeek, $endWeek])
        ->get();
        $days=StockHistory::where('type', 'withdraw')->with(['category', 'demandeur'])
        ->whereBetween('created_at', [$startDay, $endDay])
        ->get();
        // dd(DatabaseNotification::get());
        // Artisan::call('schedule:work');
        return view('home', ['categories'=>$categories, 'months'=>$months, 'days'=>$days, 'weeks'=>$weeks]);
    }
}
