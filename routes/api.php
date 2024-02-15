<?php

use App\Http\Controllers\AccountingPlanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BunkerTypeController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyGroupController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CoverTypeController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DockController;
use App\Http\Controllers\EngineTypeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\EntityTypeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentMeasureController;
use App\Http\Controllers\EquipmentSubtypeController;
use App\Http\Controllers\EquipmenttypeController;
use App\Http\Controllers\GeographicalPointController;
use App\Http\Controllers\InternationalCodeController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LineTypeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaritimeLineController;
use App\Http\Controllers\MeasuretypeController;
use App\Http\Controllers\MeasureUnitController;
use App\Http\Controllers\MeasureUnitTypeController;
use App\Http\Controllers\MovementCatalogsController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PackageTypeController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\RampTypeController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ServiceCodeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\SubdivisionController;
use App\Http\Controllers\SublocationController;
use App\Http\Controllers\SublocationTypeController;
use App\Http\Controllers\TariffCodeController;
use App\Http\Controllers\TransportTypeController;
use App\Http\Controllers\VesselBunkerController;
use App\Http\Controllers\VesselCapacityController;
use App\Http\Controllers\VesselCellLocationController;
use App\Http\Controllers\VesselCharterController;
use App\Http\Controllers\VesselCommunicationController;
use App\Http\Controllers\VesselController;
use App\Http\Controllers\VesselCoverCapacityController;
use App\Http\Controllers\VesselCoverController;
use App\Http\Controllers\VesselCoverOpeningController;
use App\Http\Controllers\VesselEngineController;
use App\Http\Controllers\VesselInfoController;
use App\Http\Controllers\VesselPreviousCodeController;
use App\Http\Controllers\VesselSisterController;
use App\Http\Controllers\VesselTechniqueController;
use App\Http\Controllers\VesselTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);

});

Route::group([
    'middleware' => 'auth:sanctum',
], function ($router) {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
    Route::apiResources([
        'country' => CountryController::class,
        'currency' => CurrencyController::class,
    ]);
});

Route::apiResource('city',CityController::class);
Route::apiResource('state',StateController::class);
Route::apiResource('user',UserController::class);
Route::apiResource('role',RoleController::class);
