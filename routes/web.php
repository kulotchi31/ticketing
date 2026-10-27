<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DeparmentController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\worker\TicketController as TicketWorker;
use App\Http\Controllers\staff\TicketController as TicketStaff;
use App\Http\Controllers\provider\TicketController as TicketProvider;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\staff\ChatAssistantController;
use App\Http\Controllers\provider\ServiceProviderController;




Route::get('/', function () {
    return view('auth.login');
})->middleware("guest");

Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login')->middleware("guest");



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {

       Route::get('/ticket/create-data', [TicketController::class, 'createData'])
        ->name('ticket.createData');



        Route::resource('admin', AdminController::class);
        Route::resource('campus', CampusController::class);
        Route::resource('department', DeparmentController::class);
        Route::resource('users', UserController::class);
        Route::resource('provider', ProviderController::class);
        Route::resource('request', RequestTypeController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('ticket', TicketController::class);








        Route::post('/get-campus', [CampusController::class, 'getCampus'])->name('admin.campus');
        Route::post('/get-department', [DeparmentController::class, 'getDepartment'])->name('admin.department');
        Route::post('/get-users', [UserController::class, 'getUsers'])->name('admin.user');
        Route::get('/departments-by-campus/{id}',[UserController::class, 'getDepartmentsByCampus'])->name('departments.by-campus');

        Route::post('/get-provider', [ProviderController::class, 'getProvider'])->name('admin.provider');


        Route::post('/get-request-types', [RequestTypeController::class, 'getRequestTypes'])->name('admin.request-type');

        Route::post('/admin/category', [CategoryController::class, 'getCategories'])
        ->name('admin.category');

        Route::get('/get-ticket', [TicketController::class, 'getTicket'])
        ->name('admin.ticket');
   
});

Route::middleware(['auth','user'])->prefix('user')->group(function () {

        Route::resource('user', UserController::class);
});


Route::middleware(['auth','worker'])->prefix('worker')->group(function () {

        Route::resource('worker', WorkerController::class);

        Route::resource('worker-ticket', TicketWorker::class);

        Route::get('/ticket-accepted', [TicketWorker::class, 'getAcceptedTicket'])
        ->name('worker-accepted-ticket');
        Route::get('/ticket-pending', [TicketWorker::class, 'showPending'])
        ->name('worker-pending');
          Route::get('/ticket-wip', [TicketWorker::class, 'showWip'])
        ->name('worker-wip');
        Route::get('/get-pending-ticket', [TicketWorker::class, 'getPendingTicket'])
        ->name('worker-pending-ticket');
          Route::get('/get-wip-ticket', [TicketWorker::class, 'getWipTicket'])
        ->name('worker-wip-ticket');

});


Route::middleware(['auth','staff'])->prefix('staff')->group(function () {

        Route::resource('staff', StaffController::class);
        Route::resource('ticket-staff', TicketStaff::class);




        Route::get('/ticket/create-data', [TicketStaff::class, 'createData'])
        ->name('staff-ticket.createData');


        Route::get('/staff-get-ticket', [TicketStaff::class, 'getTicket'])
        ->name('staff.ticket');
          Route::get('/chat-assistant', [ChatAssistantController::class, 'index'])
        ->name('staff.chat-assistant');



          Route::post('/chat-assistant/chat', [ChatAssistantController::class, 'chat'])
        ->name('staff.chat-assistant.chat');

        
});



Route::middleware(['auth','service_provider'])->prefix('provider')->group(function () {

        Route::resource('ticket-provider', TicketProvider::class);
        Route::resource('service-provider', ServiceProviderController::class);



        Route::get('/provider-get-ticket', [TicketProvider::class, 'getTicket'])
        ->name('provider.ticket');
});




require __DIR__.'/auth.php';
