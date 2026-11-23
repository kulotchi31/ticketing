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
use App\Http\Controllers\AuditLogsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\worker\TicketController as TicketWorker;
use App\Http\Controllers\staff\TicketController as TicketStaff;
use App\Http\Controllers\provider\TicketController as TicketProvider;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\staff\ChatAssistantController;
use App\Http\Controllers\provider\ServiceProviderController;
use App\Http\Controllers\provider\FacilityController;
use App\Http\Controllers\provider\StockProviderController;
use App\Http\Controllers\provider\MaintenanceController;
use App\Http\Controllers\provider\ReportController;
use App\Http\Controllers\provider\DashboardController;

use App\Http\Controllers\worker\DashboardController as WorkerDashboardController;
use App\Http\Controllers\staff\DashboardController as StaffDashboardController;



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
        Route::resource('audit', AuditLogsController::class);










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

            Route::get('/get-audit', [AuditLogsController::class, 'getAudit'])
        ->name('admin.audit');

   
});

Route::middleware(['auth','user'])->prefix('user')->group(function () {

        Route::resource('user', UserController::class);
});


Route::middleware(['auth', 'worker'])->prefix('worker')->group(function () {

    Route::resource('worker', WorkerController::class);
    Route::resource('worker-ticket', TicketWorker::class);

    Route::get('/ticket-accepted', [TicketWorker::class, 'getAcceptedTicket'])
        ->name('worker-accepted-ticket');

    Route::get('/get-pending-ticket', [TicketWorker::class, 'getPendingTicket'])
        ->name('worker-pending-ticket');

    Route::get('/get-wip-ticket', [TicketWorker::class, 'getWipTicket'])
        ->name('worker-wip-ticket');

    Route::get('/get-completed-ticket', [TicketWorker::class, 'getCompletedTicket'])
        ->name('worker-completed-ticket');

    Route::get('/get-acknowledged-ticket', [TicketWorker::class, 'getAcknowledgeTicket'])
        ->name('worker-acknowledged-ticket');

    Route::get('/ticket/{id}/pdf', [TicketWorker::class, 'printPdf'])
        ->name('worker-ticket.print');


    Route::get('/dashboard', [WorkerDashboardController::class, 'index'])->name('worker.dashboard');

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


     Route::put('/staff/ticket/{id}/acknowledge', [TicketStaff::class, 'acknowledge'])
    ->name('ticket-staff.acknowledge');

        
});



Route::middleware(['auth', 'service_provider'])->prefix('provider')->group(function () {

    // Facility & Next-Action Prediction Endpoints (BMGS only: fk_provider_id = 2)
    Route::middleware('bmgs.provider')->group(function () {
        Route::get('/facility-provider/{id}/next-action', [FacilityController::class, 'getNextAction'])
            ->name('facility-provider.next-action');

        Route::post('/facility-provider/{id}/next-action/predict', [FacilityController::class, 'predictNextAction'])
            ->name('facility-provider.next-action.predict');

        Route::post('/facility-provider/maintenance', [FacilityController::class, 'storeMaintenance'])
            ->name('facility-provider.maintenance.store');

        Route::get('/facility/create-data', [FacilityController::class, 'createData'])
            ->name('facility-provider.createData');

        Route::resource('facility-provider', FacilityController::class);
    });

    Route::resource('ticket-provider', TicketProvider::class);
    Route::resource('maintenance-provider', MaintenanceController::class);
    Route::resource('stock-provider', StockProviderController::class);
    Route::resource('service-provider', ServiceProviderController::class);
    Route::resource('report-provider', ReportController::class);

    // Ticket Tab Endpoints
    Route::get('/provider-get-ticket', [TicketProvider::class, 'getTicket'])
        ->name('provider.ticket');

    Route::get('/provider-accepted-ticket', [TicketProvider::class, 'getAcceptedTicket'])
        ->name('provider.accepted-ticket');

    Route::get('/provider-wip-ticket', [TicketProvider::class, 'getWipTicket'])
        ->name('provider.wip-ticket');

    Route::get('/provider-pending-ticket', [TicketProvider::class, 'getPendingTicket'])
        ->name('provider.pending-ticket');

    Route::get('/provider-completed-ticket', [TicketProvider::class, 'getCompletedTicket'])
        ->name('provider.completed-ticket');

    Route::get('/provider-acknowledged-ticket', [TicketProvider::class, 'getAcknowledgedTicket'])
        ->name('provider.acknowledged-ticket');

    // Ticket Print & Actions
    Route::get('/tickets/{id}/print', [TicketProvider::class, 'printTicket'])
        ->name('provider.ticket.print');

    Route::get('/ticket/create-data', [TicketProvider::class, 'createData'])
        ->name('provider.createData');

    Route::post('/tickets/{id}/approve-assign', [TicketProvider::class, 'approveAndAssign'])
        ->name('provider.tickets.approve');

    // Other Provider Routes
    Route::get('/stocks/create-data', [StockProviderController::class, 'createData'])
        ->name('stock-provider.createData');

    Route::post('/adjust', [StockProviderController::class, 'adjust'])
        ->name('stock-provider.adjust');

    Route::get('/report-provider-data', [ReportController::class, 'getData'])
        ->name('report-provider.data');

    Route::get('/report-provider-pdf', [ReportController::class, 'exportPdf'])
        ->name('report-provider.pdf');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('provider.dashboard');
});



require __DIR__.'/auth.php';
