<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EnginController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GoogleMapsController;
use App\Http\Controllers\InstructionApiController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoginApiController;
use App\Http\Controllers\MaintenanceApiController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RepportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\TaskApiController;
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
Route::get('/test', function () {
    event (new \App\Events\TestEvent());
    return 'Event envoye';
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
    Route::get('userAuth', [LoginApiController::class, 'userAp'])->name('authUser');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/redirect-home1', [App\Http\Controllers\HomeController::class, 'redirect_home1'])->name('home1');
    Route::post('/redirect-home2', [App\Http\Controllers\HomeController::class, 'makePostRequestWithGuzzle'])->name('home2');
    Route::get('/homeVue', [LoginApiController::class, 'userApi']);
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
        // 'repports'=>UserRepportController::class,
        'tasks'=>TaskController::class,
        'activities'=>ActivityController::class,
        'projects'=>ProjectController::class,
        'equipments'=>EquipmentController::class,
        'calendars'=>CalendarController::class,
        'maintenances'=>MaintenanceController::class,
        'teams' => TeamController::class,
        'priorities'=>PriorityController::class,
        'instructions'=>InstructionApiController::class,
        'regions'=>RegionController::class,
        'engins'=>EnginController::class,
        'documents'=>DocumentController::class,
        'repports'=>RepportController::class,
        'googlemaps'=>GoogleMapsController::class,


    ]);

    Route::get('/import2/{id}', [TaskApiController::class, 'extractDatesFromSheetName'])->name('extractDatesFromSheetName.imports');
    // Route::post('tasks/import', [TaskApiController::class, 'import'])->name('tasks.import');
    Route::post('tasks/import', [TaskApiController::class, 'import'])->name('tasks.imports');
    Route::post('/maintenance/import2', [MaintenanceApiController::class, 'import'])->name('maintenances.imports');
    Route::put('instruction-task', [InstructionApiController::class,'updateInstructions'])->name('instruction.updateInstructions');
        Route::get('users/{id}', action: [UserController::class, 'edit'])->name('users.edit');
        // Route::get('category/destroy/{id}', [UserController::class, 'destroy'])->name('category.destroy');
        Route::get('technician/{id}', [TechnicianController::class, 'edit'])->name('technicians.edit');
    Route::get('/settings', [ActivityController ::class, 'settings'])->name('settings');
    // Route::get('/export', [StockHistoryController::class, 'export_stock'])->name('settings');
    Route::get('/user/{id}', [UserController ::class, 'show'])->name(name: 'user.show');
});
// La page où on présente les liens de redirection vers les providers
Route::get("login-register",[SocialiteController::class, 'loginRegister']);

// La redirection vers le provider
Route::get("/redirect/{provider}", [SocialiteController::class, 'redirect'])->name('socialite.redirect');

// Le callback du provider
Route::get("/callback/{provider}", [SocialiteController::class, 'callback'])->name('socialite.callback');
Auth::routes();


// Schedule the repport:send command
// Artisan::command('schedule:repport-send', function () {
//     info("Cron Job running at ". now());
//     Artisan::call('repport:send');
// })->everyMinute()->runInBackground()->emailOutputTo(Config('app.email'));

