<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Depense;
use App\Models\Entry;
use App\Models\Maintenance;
use App\Models\StockHistory;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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
        // return 111;
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function redirect_home1(){
        $user = User::find(Auth::id());
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
    public function redirect_home2(){

    }
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
        $depenses = Depense::all();
        $total =0;
        foreach($depenses as $depense){
            $t= Task ::where('maintenance_id', $depense->maintenance_id)->count();
           $maint= Maintenance::find($depense->maintenance_id);
           if($maint->type!="quarterly"){
            $total += $t* $depense->amount;
           }else{
            $total +=  $depense->amount;
           }

        }
        $totalRealised =0;
        foreach($depenses as $depense){
            $t= Task ::where('maintenance_id', $depense->maintenance_id)->where('status', 'completed')->count();
            $maint= Maintenance::find($depense->maintenance_id);
            $totalRealised += $t* $depense->amount;
            // if($maint->type!="quarterly"){
            //     $totalRealised += $t* $depense->amount;
            //    }else{
            //     $totalRealised += $depense->amount;
            //    }
        }
        $maintenanceCancel =0;
        foreach($depenses as $depense){
            $t= Task ::where('maintenance_id', $depense->maintenance_id)->where('status', 'canceled')->count();
            $maintenanceCancel += $t* $depense->amount;
            // $maint= Maintenance::find($depense->maintenance_id);
            // if($maint->type!="quarterly"){
            //     $maintenanceCancel += $t* $depense->amount;
            //    }else{
            //     $maintenanceCancel +=  $depense->amount;
            //    }
        }
        $mouvements = StockHistory::count();
        $mouvements +=Entry::count();
        $users=User::role('technicien')->count();
        return view('home', ['mouvements'=>$mouvements,'maintenanceCancel'=>$maintenanceCancel,'techniciens'=>$users, 'maintenanceRealise'=>$totalRealised,'maintenanceBuget'=>$total, 'categories'=>$categories, 'months'=>$months, 'days'=>$days, 'weeks'=>$weeks]);
    }
}
