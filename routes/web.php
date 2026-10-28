<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Menu
    Route::prefix('menus')->controller(MenuController::class)->group(function () {

        Route::get('/', 'index')
            ->name('menus.index')
            ->middleware('check.permission:menus.index,can_view');

        Route::get('/create', 'create')
            ->name('menus.create')
            ->middleware('check.permission:menus.index,can_create');

        Route::post('/', 'store')
            ->name('menus.store')
            ->middleware('check.permission:menus.index,can_create');

        Route::get('/{menu}', 'show')
            ->name('menus.show')
            ->middleware('check.permission:menus.index,can_view');

        Route::get('/{menu}/edit', 'edit')
            ->name('menus.edit')
            ->middleware('check.permission:menus.index,can_edit');

        Route::put('/{menu}', 'update')
            ->name('menus.update')
            ->middleware('check.permission:menus.index,can_edit');

        Route::delete('/{menu}', 'destroy')
            ->name('menus.destroy')
            ->middleware('check.permission:menus.index,can_delete');
    });

    // User
    Route::prefix('users')->controller(UserController::class)->group(function () {

        Route::get('/', 'index')
            ->name('users.index')
            ->middleware('check.permission:users.index,can_view');

        Route::get('/create', 'create')
            ->name('users.create')
            ->middleware('check.permission:users.index,can_create');

        Route::post('/', 'store')
            ->name('users.store')
            ->middleware('check.permission:users.index,can_create');

        Route::get('/{user}', 'show')
            ->name('users.show')
            ->middleware('check.permission:users.index,can_view');

        Route::get('/{user}/edit', 'edit')
            ->name('users.edit')
            ->middleware('check.permission:users.index,can_edit');

        Route::put('/{user}', 'update')
            ->name('users.update')
            ->middleware('check.permission:users.index,can_edit');

        Route::delete('/{user}', 'destroy')
            ->name('users.destroy')
            ->middleware('check.permission:users.index,can_delete');
    });

    // User Level
    Route::prefix('user-levels')->controller(UserLevelController::class)->group(function () {

        Route::get('/', 'index')
            ->name('user-levels.index')
            ->middleware('check.permission:user-levels.index,can_view');

        Route::get('/create', 'create')
            ->name('user-levels.create')
            ->middleware('check.permission:user-levels.index,can_create');

        Route::post('/', 'store')
            ->name('user-levels.store')
            ->middleware('check.permission:user-levels.index,can_create');

        Route::get('/{userLevel}', 'show')
            ->name('user-levels.show')
            ->middleware('check.permission:user-levels.index,can_view');

        Route::get('/{userLevel}/edit', 'edit')
            ->name('user-levels.edit')
            ->middleware('check.permission:user-levels.index,can_edit');

        Route::put('/{userLevel}', 'update')
            ->name('user-levels.update')
            ->middleware('check.permission:user-levels.index,can_edit');

        Route::delete('/{userLevel}', 'destroy')
            ->name('user-levels.destroy')
            ->middleware('check.permission:user-levels.index,can_delete');

        Route::get('/{userLevel}/permissions', 'permissions')
            ->name('user-levels.permissions')
            ->middleware('check.permission:user-levels.index,can_edit');

        Route::put('/{userLevel}/permissions', 'updatePermissions')
            ->name('user-levels.permissions.update')
            ->middleware('check.permission:user-levels.index,can_edit');
    });

    // Kategori
    Route::prefix('categories')->controller(CategoriesController::class)->group(function () {

        Route::get('/', 'index')
            ->name('categories.index')
            ->middleware('check.permission:categories.index,can_view');

        Route::get('/create', 'create')
            ->name('categories.create')
            ->middleware('check.permission:categories.index,can_create');

        Route::post('/', 'store')
            ->name('categories.store')
            ->middleware('check.permission:categories.index,can_create');

        Route::get('/{Categories}', 'show')
            ->name('categories.show')
            ->middleware('check.permission:categories.index,can_view');

        Route::get('/{Categories}/edit', 'edit')
            ->name('categories.edit')
            ->middleware('check.permission:categories.index,can_edit');

        Route::put('/{Categories}', 'update')
            ->name('categories.update')
            ->middleware('check.permission:categories.index,can_edit');

        Route::delete('/{Categories}', 'destroy')
            ->name('categories.destroy')
            ->middleware('check.permission:categories.index,can_delete');
    });

    // Sub Kategori
    Route::prefix('sub-categories')->controller(SubCategoriesController::class)->group(function () {

        Route::get('/', 'index')
            ->name('sub-categories.index')
            ->middleware('check.permission:sub-categories.index,can_view');

        Route::get('/create', 'create')
            ->name('sub-categories.create')
            ->middleware('check.permission:sub-categories.index,can_create');

        Route::post('/', 'store')
            ->name('sub-categories.store')
            ->middleware('check.permission:sub-categories.index,can_create');

        Route::get('/{SubCategories}', 'show')
            ->name('sub-categories.show')
            ->middleware('check.permission:sub-categories.index,can_view');

        Route::get('/{SubCategories}/edit', 'edit')
            ->name('sub-categories.edit')
            ->middleware('check.permission:sub-categories.index,can_edit');

        Route::put('/{SubCategories}', 'update')
            ->name('sub-categories.update')
            ->middleware('check.permission:sub-categories.index,can_edit');

        Route::delete('/{SubCategories}', 'destroy')
            ->name('sub-categories.destroy')
            ->middleware('check.permission:sub-categories.index,can_delete');
    });

    // Produk
    Route::prefix('products')->controller(ProductController::class)->group(function () {

        Route::get('/', 'index')
            ->name('products.index')
            ->middleware('check.permission:products.index,can_view');

        Route::get('/create', 'create')
            ->name('products.create')
            ->middleware('check.permission:products.index,can_create');

        Route::post('/', 'store')
            ->name('products.store')
            ->middleware('check.permission:products.index,can_create');

        Route::get('/{product}', 'show')
            ->name('products.show')
            ->middleware('check.permission:products.index,can_view');

        Route::get('/{product}/edit', 'edit')
            ->name('products.edit')
            ->middleware('check.permission:products.index,can_edit');

        Route::put('/{product}', 'update')
            ->name('products.update')
            ->middleware('check.permission:products.index,can_edit');

        Route::delete('/{product}', 'destroy')
            ->name('products.destroy')
            ->middleware('check.permission:products.index,can_delete');
    });

    // Vendor
    Route::prefix('vendors')->controller(VendorController::class)->group(function () {

        Route::get('/', 'index')
            ->name('vendors.index')
            ->middleware('check.permission:vendors.index,can_view');

        Route::get('/create', 'create')
            ->name('vendors.create')
            ->middleware('check.permission:vendors.index,can_create');

        Route::post('/', 'store')
            ->name('vendors.store')
            ->middleware('check.permission:vendors.index,can_create');

        Route::get('/{vendor}', 'show')
            ->name('vendors.show')
            ->middleware('check.permission:vendors.index,can_view');

        Route::get('/{vendor}/edit', 'edit')
            ->name('vendors.edit')
            ->middleware('check.permission:vendors.index,can_edit');

        Route::put('/{vendor}', 'update')
            ->name('vendors.update')
            ->middleware('check.permission:vendors.index,can_edit');

        Route::delete('/{vendor}', 'destroy')
            ->name('vendors.destroy')
            ->middleware('check.permission:vendors.index,can_delete');
    });
});
