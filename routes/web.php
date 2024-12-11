<?php

use App\Http\Controllers\ViewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\InvController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\InventoryBrandController;
use App\Http\Controllers\MedfixController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\SolvingController;
use App\Http\Controllers\DepartmentController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/departments/search', [DepartmentController::class, 'search'])->name('departments.search');
Route::get('/tutorial', function () { return view('tutorial');});
///////////////////// login
//Route::get('/register', [ViewController::class, 'showRegister'])->name('register');
//Route::post('/register', [AuthController::class, 'register']);

// Line Notify
Route::post('/notify', [App\Http\Controllers\NotifyController::class, 'send']);

Route::group(['middleware' => ['auth']], function () {
    ///////////////////// Repair
    Route::get('/inventory_search', [MedfixController::class, 'search'])->name('inventory_search');
    Route::post('/inventory_search', [MedfixController::class, 'search_sm'])->name('inventory_search_sm');
    Route::get('/medfix', [MedfixController::class, 'index'])->name('medfix');
    Route::put('/closejob/{id}', [MedfixController::class, 'closejob'])->name('closejob')->middleware(['role:admin']);
    Route::post('/regismedfix', [MedfixController::class, 'regismedfix'])->name('regismedfix');
    Route::put('/storemedfix/{id}', [MedfixController::class, 'store'])->name('storemedfix');
    Route::get('/inventory/{id}', [InvController::class, 'profile'])->name('inventory')->middleware(['role:user']);
    Route::delete('/medfix_destroy/{id}', [MedfixController::class, 'destroy'])->name('medfix.destroy')->middleware(['role:admin']);
    ///////////////////// logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

    ///////////////////// Dashbaord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['role:admin']);

    ///////////////////// project
    Route::get('/projects_index', [ProjectController::class, 'index'])->name('project.index')->middleware(['role:admin']);
    Route::get('/projects_create', [ProjectController::class, 'create'])->name('projects.create')->middleware(['role:admin']);
    //Route::post('/projects_store', [ProjectController::class, 'store'])->name('projects.store')->middleware(['role:admin']);
    Route::get('/projects_edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware(['role:admin']);
    Route::get('/projects/{id}/delete', [ProjectController::class, 'delete'])->name('projects.delete')->middleware(['role:admin']);
    Route::delete('/projects_confirm/{id}', [ProjectController::class, 'confirm'])->name('projects.confirm')->middleware(['role:admin']);
    Route::put('/projects_update', [ProjectController::class, 'update'])->name('projects.update')->middleware(['role:admin']);
    Route::delete('/projects_destroy', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware(['role:admin']);
    Route::resource('projects', ProjectController::class);

    ///////////////////// Inventory
    Route::get('/inventorys_index', [InvController::class, 'index'])->name('inventorys.index')->middleware(['role:admin']);
    Route::get('/inventorys_create', [InvController::class, 'create'])->name('inventorys.create')->middleware(['role:admin']);
    Route::post('/inventorys_store', [InvController::class, 'store'])->name('inventorys.store')->middleware(['role:admin']);
    Route::get('/inventorys_show', [InvController::class, 'show'])->name('inventorys.show')->middleware(['role:admin']);
    Route::get('/inventorys_edit', [InvController::class, 'edit'])->name('inventorys.edit')->middleware(['role:admin']);
    Route::get('/inventorys/{id}/qr', [InvController::class, 'showqr'])->name('inventorys.qr')->middleware(['role:admin']);
    Route::match(['get', 'post'], '/inventorys/mulqr', [InvController::class, 'showmulqr'])->name('inventorys.mulqr')->middleware(['role:admin']);
    Route::put('/inventorys_update', [InvController::class, 'update'])->name('inventorys.update')->middleware(['role:admin']);
    Route::delete('/inventorys_destroy', [InvController::class, 'destroy'])->name('inventorys.destroy')->middleware(['role:admin']);
    Route::resource('inventorys', InvController::class);




    ///////////////////// User Permission
    Route::get('/404notpermission', function () {
        return view('users.notpermission');
    })->name('users.notpermission');

    Route::get('users/permission', [UserPermissionController::class, 'index'])->name('users.permissions.index')->middleware(['role:superadmin']);
    Route::get('users/{user}/permission', [UserPermissionController::class, 'edit'])->name('users.permissions.edit')->middleware(['role:superadmin']);
    Route::post('users/{user}/permission', [UserPermissionController::class, 'update'])->name('users.permissions.update')->middleware(['role:superadmin']);

    ///////////////////// Brands
    Route::get('/inventory_brands_create', [InventoryBrandController::class, 'create'])->name('inventory_brands.create')->middleware(['role:admin']);
    Route::post('/inventory_brands', [InventoryBrandController::class, 'store'])->name('inventory_brands.store')->middleware(['role:admin']);
    Route::put('/inventory_brands_update/{id}', [InventoryBrandController::class, 'update'])->name('inventory_brands.update')->middleware(['role:admin']);
    Route::delete('/inventory_brands_destroy/{id}', [InventoryBrandController::class, 'destroy'])->name('inventory_brands.destroy')->middleware(['role:admin']);


      ///////////////////// issue
      Route::get('/problem_issue_create', [IssueController::class, 'create'])->name('problem_issue.create')->middleware(['role:admin']);
      Route::post('/problem_issue_store', [IssueController::class, 'store'])->name('problem_issue.store')->middleware(['role:admin']);
      Route::put('/problem_issue_update/{id}', [IssueController::class, 'update'])->name('problem_issue.update')->middleware(['role:admin']);
      Route::delete('/problem_issue_destroy/{id}', [IssueController::class, 'destroy'])->name('problem_issue.destroy')->middleware(['role:admin']);


        ///////////////////// solving
    Route::get('/problem_solving_create', [SolvingController::class, 'create'])->name('problem_solving.create')->middleware(['role:admin']);
    Route::post('/problem_solving_store', [SolvingController::class, 'store'])->name('problem_solving.store')->middleware(['role:admin']);
    Route::put('/problem_solving_update/{id}', [SolvingController::class, 'update'])->name('problem_solving.update')->middleware(['role:admin']);
    Route::delete('/problem_solving_destroy/{id}', [SolvingController::class, 'destroy'])->name('problem_solving.destroy')->middleware(['role:admin']);


      /////////////////////department
      Route::get('department.create', [DepartmentController::class, 'create'])->name('department.create')->middleware(['role:admin']);
      Route::post('department.store', [DepartmentController::class, 'store'])->name('department.store')->middleware(['role:admin']);
      Route::put('/department_update/{id}', [DepartmentController::class, 'update'])->name('department.update')->middleware(['role:admin']);
      Route::delete('/department_destroy/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy')->middleware(['role:admin']);
});
