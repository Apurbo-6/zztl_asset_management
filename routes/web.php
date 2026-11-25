<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AuthController,
    DashboardController,
    AssetController,
    CategoryController,
    SupplierController,
    PurchaseController,
    DepartmentController,
    AssetAssignmentController,
    UserController,
    RoleController,
    ActivityLogController,
    AttachmentController
};


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Home / Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', DashboardController::class)
        ->middleware('can:dashboard.view')
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Assets
    |--------------------------------------------------------------------------
    */

    Route::get('/assets', [AssetController::class, 'index'])
        ->middleware('can:assets.view')
        ->name('assets.index');

    Route::get('/assets/create', [AssetController::class, 'create'])
        ->middleware('can:assets.create')
        ->name('assets.create');

    Route::post('/assets', [AssetController::class, 'store'])
        ->middleware('can:assets.create')
        ->name('assets.store');

    Route::get('/assets/{asset}', [AssetController::class, 'show'])
        ->middleware('can:assets.view')
        ->name('assets.show');

    Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])
        ->middleware('can:assets.update')
        ->name('assets.edit');

    Route::put('/assets/{asset}', [AssetController::class, 'update'])
        ->middleware('can:assets.update')
        ->name('assets.update');

    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->middleware('can:assets.delete')
        ->name('assets.destroy');


    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */

    Route::get('/purchases', [PurchaseController::class, 'index'])
        ->middleware('can:purchases.view')
        ->name('purchases.index');

    Route::get('/purchases/create', [PurchaseController::class, 'create'])
        ->middleware('can:purchases.create')
        ->name('purchases.create');

    Route::post('/purchases', [PurchaseController::class, 'store'])
        ->middleware('can:purchases.create')
        ->name('purchases.store');

    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])
        ->middleware('can:purchases.view')
        ->name('purchases.show');

    Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])
        ->middleware('can:purchases.update')
        ->name('purchases.edit');

    Route::put('/purchases/{purchase}', [PurchaseController::class, 'update'])
        ->middleware('can:purchases.update')
        ->name('purchases.update');

    Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])
        ->middleware('can:purchases.delete')
        ->name('purchases.destroy');


    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    Route::get('/categories', [CategoryController::class, 'index'])
        ->middleware('can:categories.view')
        ->name('categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])
        ->middleware('can:categories.create')
        ->name('categories.create');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->middleware('can:categories.create')
        ->name('categories.store');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
        ->middleware('can:categories.update')
        ->name('categories.edit');

    Route::put('/categories/{category}', [CategoryController::class, 'update'])
        ->middleware('can:categories.update')
        ->name('categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->middleware('can:categories.delete')
        ->name('categories.destroy');


    /*
    |--------------------------------------------------------------------------
    | Suppliers
    |--------------------------------------------------------------------------
    */

    Route::get('/suppliers', [SupplierController::class, 'index'])
        ->middleware('can:suppliers.view')
        ->name('suppliers.index');

    Route::get('/suppliers/create', [SupplierController::class, 'create'])
        ->middleware('can:suppliers.create')
        ->name('suppliers.create');

    Route::post('/suppliers', [SupplierController::class, 'store'])
        ->middleware('can:suppliers.create')
        ->name('suppliers.store');

    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])
        ->middleware('can:suppliers.update')
        ->name('suppliers.edit');

    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])
        ->middleware('can:suppliers.update')
        ->name('suppliers.update');

    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])
        ->middleware('can:suppliers.delete')
        ->name('suppliers.destroy');


    /*
    |--------------------------------------------------------------------------
    | Departments
    |--------------------------------------------------------------------------
    */

    Route::get('/departments', [DepartmentController::class, 'index'])
        ->middleware('can:departments.view')
        ->name('departments.index');

    Route::get('/departments/create', [DepartmentController::class, 'create'])
        ->middleware('can:departments.create')
        ->name('departments.create');

    Route::post('/departments', [DepartmentController::class, 'store'])
        ->middleware('can:departments.create')
        ->name('departments.store');

    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])
        ->middleware('can:departments.update')
        ->name('departments.edit');

    Route::put('/departments/{department}', [DepartmentController::class, 'update'])
        ->middleware('can:departments.update')
        ->name('departments.update');

    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])
        ->middleware('can:departments.delete')
        ->name('departments.destroy');


    /*
    |--------------------------------------------------------------------------
    | Asset Assignments
    |--------------------------------------------------------------------------
    */

    Route::get('/asset-assignments', [AssetAssignmentController::class, 'index'])
        ->middleware('can:asset_assignments.view')
        ->name('asset-assignments.index');

    Route::get('/asset-assignments/create', [AssetAssignmentController::class, 'create'])
        ->middleware('can:asset_assignments.create')
        ->name('asset-assignments.create');

    Route::post('/asset-assignments', [AssetAssignmentController::class, 'store'])
        ->middleware('can:asset_assignments.create')
        ->name('asset-assignments.store');

    Route::get('/asset-assignments/{assetAssignment}/edit', [AssetAssignmentController::class, 'edit'])
        ->middleware('can:asset_assignments.update')
        ->name('asset-assignments.edit');

    Route::put('/asset-assignments/{assetAssignment}', [AssetAssignmentController::class, 'update'])
        ->middleware('can:asset_assignments.update')
        ->name('asset-assignments.update');

    Route::post('/asset-assignments/{assetAssignment}/return', [AssetAssignmentController::class, 'returnAsset'])
        ->middleware('can:asset_assignments.update')
        ->name('asset-assignments.return');


    /*
    |--------------------------------------------------------------------------
    | Attachments
    |--------------------------------------------------------------------------
    */

    Route::get('/attachments/{attachment}', [AttachmentController::class, 'show'])
        ->name('attachments.show');

    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])
        ->name('attachments.destroy');


    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    Route::get('/roles', [RoleController::class, 'index'])
        ->middleware('can:roles.manage')
        ->name('roles.index');

    Route::get('/roles/create', [RoleController::class, 'create'])
        ->middleware('can:roles.manage')
        ->name('roles.create');

    Route::post('/roles', [RoleController::class, 'store'])
        ->middleware('can:roles.manage')
        ->name('roles.store');

    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])
        ->middleware('can:roles.manage')
        ->name('roles.edit');

    Route::put('/roles/{role}', [RoleController::class, 'update'])
        ->middleware('can:roles.manage')
        ->name('roles.update');

    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])
        ->middleware('can:roles.manage')
        ->name('roles.destroy');


    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('can:users.manage');


    /*
    |--------------------------------------------------------------------------
    | Activity Logs
    |--------------------------------------------------------------------------
    */

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
        ->middleware('can:activity_logs.view')
        ->name('activity-logs.index');
});
