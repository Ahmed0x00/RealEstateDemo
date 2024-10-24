<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\ResourcesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Apply 'web' and 'auth' middleware to all routes
Route::middleware(['web', 'auth'])->group(function () {

    // User management routes
    Route::controller(UserController::class)->group(function () {
        Route::get('/employees', 'getEmployees');
        Route::get('/clients', 'getClients');
        Route::get('/employees/{id}', 'getEmployeeById');
        Route::get('/clients/{id}', 'getClientById');
        Route::post('/clients', 'createClient');
        Route::put('/clients/{id}', 'updateClient');
        Route::delete('/clients/{id}', 'destroyClient');
    });

    // Transaction management routes
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactions', 'getAllTransactions');
        Route::get('/transactions/{id}', 'getTransactionById');
        Route::get('/incomes', 'getAllIncomes');
        Route::get('/outcomes', 'getAllOutcomes');
        Route::delete('/transactions/{id}', 'deleteTransaction');
        Route::put('/transactions/{id}', 'updateTransaction');
        Route::post('/transactions/income', 'createIncome');
        Route::post('/transactions/outcome', 'createOutcome');
        Route::get('/today-summary', 'getTodaySummary');
    });

    // Routes for Units
    Route::controller(UnitsController::class)->group(function () {
        Route::get('/units', 'getAllUnits'); // Get all units
        Route::post('/units', 'createUnit'); // Create a new unit
        Route::get('/units/{id}', 'getUnitById'); // Get a specific unit by ID
        Route::put('/units/{id}', 'updateUnit'); // Update a specific unit by ID
        Route::delete('/units/{id}', 'deleteUnit'); // Delete a specific unit by ID

    });

        // Routes for Resources
        Route::controller(ResourcesController::class)->group(function () {
        Route::get('/resources', 'getAllResources'); // Get all resources
        Route::post('/resources', 'createResource'); // Create a new resource
        Route::get('/resources/{id}', 'getResourceById'); // Get a specific resource by ID
        Route::put('/resources/{id}', 'updateResource'); // Update a specific resource by ID
        Route::delete('/resources/{id}', 'deleteResource'); // Delete a specific resource by ID
    });

});


Route::middleware(['web', 'auth', 'owner'])->controller(UserController::class)->group(function () {
    Route::post('/employees', 'createEmployee');
    Route::put('/employees/{id}', 'updateEmployee');
    Route::get('/users/{id}', 'show');
    Route::get('/users', 'index');
    Route::delete('/employees/{id}', 'destroyEmployee');
    Route::delete('/users/{id}', 'destroy'); // Delete user
});