<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InstructionApiController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UnityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRepportController;
use App\Http\Controllers\TeamController;
use App\Models\User;
use App\Notifications\NewRegister;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Config;

Route::get('/', function () {
    // Artisan::queue('repport:send')->onQueue('commands');
    // Moved this to a dedicated route for better control and security
    // Artisan::command('repport:send', function(){
    //     info("Cron Job running at ". now());
    // })->everyMinute()->runInBackground()->emailOutputTo(Config('app.email'));;
    return redirect()->route('login');
});

// New route to execute Artisan commands
Route::get('/artisan/{command}', function ($command) {
    // List of allowed commands
    // $allowedCommands = [
    //     'repport:send',
    //     'app:check-task',
    //     // Add other commands here if needed
    // ];

    // if (!in_array($command, $allowedCommands)) {
    //     return "Command not allowed.";
    // }

    try {
        Artisan::call($command);
        return "Command '$command' executed successfully.\n" . Artisan::output();
    } catch (\Exception $e) {
        return "Error executing command '$command': " . $e->getMessage();
    }
})->middleware('auth')->name('artisan.run'); // Added auth middleware for security


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
        'teams' => TeamController::class,
        'priorities'=>PriorityController::class,
        'instructions'=>InstructionApiController::class,

    ]);
    Route::put('instruction-task', [InstructionApiController::class,'updateInstructions'])->name('instruction.updateInstructions');
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

// Schedule the repport:send command
// Artisan::command('schedule:repport-send', function () {
//     info("Cron Job running at ". now());
//     Artisan::call('repport:send');
// })->everyMinute()->runInBackground()->emailOutputTo(Config('app.email'));

