<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test',function(){
    $statuses = [
        'buy_simcard' => 'Buy simcard',
        'refound' => 'Refaund',
        'refound' => 'Refaund',
        'new_order' => 'New order',
        'order_accepted' => 'Order accepted!',
        'cancelled' => 'Cancelled',
        'added_other_plan' => 'Added additional plan',

    ];
});

Route::post('/column/update',[\App\Http\Controllers\Admin\ColumnController::class,'update'])->name('column.update');

Route::redirect('/','/admin/application/list/new');
// Route::get('/test',[App\Http\Controllers\TestController::class,'index']);
Route::redirect('/dashboard','admin/dashboard');
Route::middleware(['auth','super_admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::resource('provider',App\Http\Controllers\Admin\ProviderController::class);
    Route::post('provider/pay',[App\Http\Controllers\Admin\ProviderController::class,'pay'])->name('provider.pay');

    // setttings
    Route::get('settings',[App\Http\Controllers\Admin\SettingsController::class,'editGlobalSettings'])->name('edit.global.settings');
    Route::put('settings/update',[App\Http\Controllers\Admin\SettingsController::class,'updateGlobalSettings'])->name('update.global.settings');
    Route::get('settings/payment-type',[App\Http\Controllers\Admin\SettingsController::class,'editPaymentTypes'])->name('edit.payment.types');
    Route::put('settings/payment-type/store',[App\Http\Controllers\Admin\SettingsController::class,'storePaymentTypes'])->name('update.payment.types');
    Route::delete('settings/payment-type/delete/{id}',[App\Http\Controllers\Admin\SettingsController::class,'deletePaymentTypes'])->name('delete.payment.types');

    Route::get('settings/status',[App\Http\Controllers\Admin\SettingsController::class,'editStatus'])->name('edit.status');
    Route::put('settings/status/update',[App\Http\Controllers\Admin\SettingsController::class,'updateStatus'])->name('update.status');

    Route::resource('permission',App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('role',App\Http\Controllers\Admin\RoleController::class);
    Route::resource('user',App\Http\Controllers\Admin\UserController::class);

    Route::resource('plan',App\Http\Controllers\Admin\PlanController::class);
    Route::get('additionally/plan/{type?}',[App\Http\Controllers\Admin\PlanController::class,'index'])->name('additionally.plan');
    Route::resource('region',App\Http\Controllers\Admin\RegionController::class);
    Route::resource('region_group',App\Http\Controllers\Admin\RegionGroupController::class);
    Route::resource('listproduct',App\Http\Controllers\Admin\ListproductController::class);
    Route::resource('newp',App\Http\Controllers\Admin\NewpController::class);

    Route::resource('simcard',App\Http\Controllers\Admin\SimCardController::class);
    Route::get('simcard/change/agent',[App\Http\Controllers\Admin\SimCardController::class,'changeAgent'])->name('simcard.change.agent');
    Route::post('simcard/change/agent/store',[App\Http\Controllers\Admin\SimCardController::class,'changeAgentStore'])->name('simcard.change.agent.store');
    Route::get('agent/simcards',[App\Http\Controllers\Admin\SimCardController::class,'mycards'])->name('agent.simcards');
    Route::get('simcard/create/mass',[App\Http\Controllers\Admin\SimCardController::class,'MassCreate'])->name('simcard.create.mass');
    Route::post('simcard/import/mass',[App\Http\Controllers\Admin\SimCardController::class,'MassImport'])->name('simcard.import.mass');
    Route::post('simcard/store/mass',[App\Http\Controllers\Admin\SimCardController::class,'MassStore'])->name('simcard.store.mass');

    Route::resource('agent',App\Http\Controllers\Admin\AgentController::class);
    Route::post('agent/pay',[App\Http\Controllers\Admin\AgentController::class,'pay'])->name('agent.pay');
});
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function(){

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');


    Route::resource('customer',App\Http\Controllers\Admin\CustomerController::class);
    // Route::resource('report',App\Http\Controllers\Admin\ReportController::class);
    Route::get('report/{report_type}',[App\Http\Controllers\Admin\ReportController::class,'index'])->name('report');

    Route::get('application/additional/{application}',[App\Http\Controllers\Admin\ApplicationController::class,'addtionalPlan'])->name('application.additional');
    Route::put('application/additional/{application}',[App\Http\Controllers\Admin\ApplicationController::class,'storeAddtionalPlan'])->name('application.additional.store');
    Route::get('application/list/{status}',[App\Http\Controllers\Admin\ApplicationController::class,'index'])->name('application.index');
    Route::get('application/create/{status}',[App\Http\Controllers\Admin\ApplicationController::class,'create'])->name('application.create');
    Route::post('application/status/confirm',[App\Http\Controllers\Admin\ApplicationController::class,'confirm'])->name('application.status.confirm');
    Route::get('application/show/{id}',[App\Http\Controllers\Admin\ApplicationController::class,'show'])->name('application.show');
    Route::get('application/edit/{id}',[App\Http\Controllers\Admin\ApplicationController::class,'edit'])->name('application.edit');
    Route::post('application/store',[App\Http\Controllers\Admin\ApplicationController::class,'store'])->name('application.store');
    Route::put('application/update/{id}',[App\Http\Controllers\Admin\ApplicationController::class,'update'])->name('application.update');
    Route::delete('application/destroy/{id}',[App\Http\Controllers\Admin\ApplicationController::class,'destroy'])->name('application.destroy');
});


require __DIR__.'/auth.php';
