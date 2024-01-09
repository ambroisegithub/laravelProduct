<?php

use App\Http\Controllers\productController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WomenAccountCompletionController;
use App\Http\Controllers\ClinicalDataController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\EmergencyAlertController;

Route::post('/upload-image', [Controller::class, 'uploadImage']);
// Routes for WomenAccountCompletionController
Route::post('/women-account-completion', [WomenAccountCompletionController::class, 'store']);

// user
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'Login']);
Route::delete('/DeleteAllUsers', [AuthController::class, 'deleteAll']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Update the namespace here as well
Route::post('/accounts', [AccountController::class, 'create']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Public Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/products', [productController::class, 'store']);

Route::delete('/products', [ProductController::class, 'deleteAll']);
// Protected Routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::patch('/products/{id}', [productController::class, 'update']);
    Route::delete('/products/{id}', [productController::class, 'destroy']);
});

//pregnant women account completion

// Index
Route::get('/women-account-completion', [WomenAccountCompletionController::class, 'Getall']);

// Store
// Route::post('/pregnant', [PregnantWomenAccountcompleteController::class, 'store']);

// Show
Route::get('/women-account-completion/{id}', [WomenAccountCompletionController::class, 'getById']);

// Update
Route::patch('/women-account-completion/{id}', [WomenAccountCompletionController::class, 'updateAccount']);

// Destroy
Route::delete('/women-account-completion/{id}', [WomenAccountCompletionController::class, 'destroyAccount']);

// Delete All
Route::delete('/women-account-completion', [WomenAccountCompletionController::class, 'deleteAll']);

// Search
Route::get('/accounts/search/{fullname}', [AccountController::class, 'search']);


// Clinic Data
Route::post('/clinic-data', [ClinicalDataController::class, 'ClinicalData']);
Route::get('/clinic-data', [ClinicalDataController::class, 'getAllClinicalData']);
Route::get('/clinic-data/{id}', [ClinicalDataController::class, 'getOneClinicalData']);
Route::delete('/clinic-data/{id}', [ClinicalDataController::class, 'deleteClinicalData']);
Route::put('/clinic-data/{id}', [ClinicalDataController::class, 'updateClinicalData']);

// Appointment
Route::post('/appointment', [AppointmentController::class, 'Appointment']);
Route::get('/appointments', [AppointmentController::class, 'getAllAppointments']);
Route::get('/appointments/{id}', [AppointmentController::class, 'getOneAppointment']);
Route::put('/appointments/{id}', [AppointmentController::class, 'updateAppointment']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'deleteAppointment']);


// Feedback


Route::post('/feedback', [FeedbackController::class, 'postFeedback']);
Route::get('/feedback', [FeedbackController::class, 'getAllFeedback']);
Route::get('/feedback/{id}', [FeedbackController::class, 'getOneFeedback']);
Route::put('/feedback/{id}', [FeedbackController::class, 'updateFeedback']);
Route::delete('/feedback/{id}', [FeedbackController::class, 'deleteFeedback']);


// EmergencyAlert

Route::get('/emergency-alerts', [EmergencyAlertController::class, 'getAllEmergencyAlerts']);
Route::get('/emergency-alerts/{id}', [EmergencyAlertController::class, 'getOneEmergencyAlert']);
Route::post('/emergency-alerts', [EmergencyAlertController::class, 'createEmergencyAlert']);
Route::put('/emergency-alerts/{id}', [EmergencyAlertController::class, 'updateEmergencyAlert']);
Route::delete('/emergency-alerts/{id}', [EmergencyAlertController::class, 'deleteEmergencyAlert']);