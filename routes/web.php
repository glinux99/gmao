<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UnityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRepportController;
use App\Models\User;
use App\Notifications\NewRegister;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;

Route::get('/', function () {
    // Artisan::queue('repport:send')->onQueue('commands');
    Artisan::command('repport:send', function(){
        info("Cron Job running at ". now());
    })->everyMinute()->runInBackground()->emailOutputTo(Config('app.email'));;
    return redirect()->route('login');
});
Route::group(['middleware' =>[ 'auth']], function(){
    Route::resources([
        'sorties'=>StockHistoryController::class,
        'entries'=>EntryController::class,
        'stock-histories'=>StockHistoryController::class,
        'roles'=>RoleController::class,
        'unities'=>UnityController::class,
        'categories'=>CategoryController::class,
        'permissions'=>PermissionController::class,
        'users'=>UserController::class,
        'inventories'=>InventoryController::class,
        'technicians'=>TechnicianController::class,
        'repports'=>UserRepportController::class,
        'tasks'=>TaskController::class,
        'activities'=>ActivityController::class,
        'projects'=>ProjectController::class,
        'equipments'=>EquipmentController::class,
        'calendars'=>CalendarController::class,
        'maintenances'=>MaintenanceController::class,

    ]);
        Route::get('users/{id}', action: [UserController::class, 'edit'])->name('users.edit');
        // Route::get('category/destroy/{id}', [UserController::class, 'destroy'])->name('category.destroy');
        Route::get('technician/{id}', [TechnicianController::class, 'edit'])->name('technicians.edit');
    Route::get('/settings', [ActivityController ::class, 'settings'])->name('settings');
    // Route::get('/export', [StockHistoryController::class, 'export_stock'])->name('settings');
    Route::get('/user/{id}', [UserController ::class, 'show'])->name(name: 'user.show');
});
// Route::get(uri: '/export', [StockHistoryController::class, 'export_stock']);
Route::get('/email', function(){
    $user = User::find(2);
$user->notify(new NewRegister ([
    "title"=>"A new user has visited on your application.",
    "greeting"=>"Bonjour"
]));
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
