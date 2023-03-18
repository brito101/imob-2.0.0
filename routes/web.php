<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Web\FilterController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\ACL\PermissionController;

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

/* * Web */
Route::namespace('Web')->name('web.')->group(function () {
    /** Página inicial */
    Route::get('/', [WebController::class, 'home'])->name('home');
    /** Página de compra */
    Route::get('/quero-comprar', [WebController::class, 'buy'])->name('buy');
    /** Página de compra específica de um imóvel  */
    Route::get('/quero-comprar/{slug}', [WebController::class, 'buyProperty'])->name('buyProperty');
    /** Página de locação */
    Route::get('/quero-alugar', [WebController::class, 'rent'])->name('rent');
    /** Página de locação específica de um imóvel  */
    Route::get('/quero-alugar/{slug}', [WebController::class, 'rentProperty'])->name('rentProperty');
    /** Página de filtro */
    Route::match(['post', 'get'], '/filtro', [WebController::class, 'filter'])->name('filter');
    /** Página de experiências */
    Route::get('/experiencias', [WebController::class, 'experience'])->name('experience');
    /** Página de categorias de experiências */
    Route::get('/experiencias/{slug}', [WebController::class, 'experienceCategory'])->name('experienceCategory');
    /** Página de destaque */
    Route::get('/destaque', [WebController::class, 'spotlight'])->name('spotlight');
    /** Página de contato */
    Route::get('/contato', [WebController::class, 'contact'])->name('contact');
    Route::post('/contato/sendEmail', [WebController::class, 'sendEmail'])->name('sendEmail');
    Route::get('/contato/sucesso', [WebController::class, 'sendEmailSuccess'])->name('sendEmailSuccess');
    /** Página de Política de Privacidade */
    Route::get('/politica-de-privacidade', [WebController::class, 'policy'])->name('policy');
});

/** Filter */
Route::namespace('Web')->name('component.main-filter.')->group(function () {
    Route::post('main-filter/search', [FilterController::class, 'search'])->name('search');
    Route::post('main-filter/category', [FilterController::class, 'category'])->name('category');
    Route::post('main-filter/type', [FilterController::class, 'type'])->name('type');
    Route::post('main-filter/neighborhood', [FilterController::class, 'neighborhood'])->name('neighborhood');
    Route::post('main-filter/bedrooms', [FilterController::class, 'bedrooms'])->name('bedrooms');
    Route::post('main-filter/suites', [FilterController::class, 'suites'])->name('suites');
    Route::post('main-filter/bathrooms', [FilterController::class, 'bathrooms'])->name('bathrooms');
    Route::post('main-filter/garage', [FilterController::class, 'garage'])->name('garage');
    Route::post('main-filter/price-base', [FilterController::class, 'priceBase'])->name('priceBase');
    Route::post('main-filter/price-limit', [FilterController::class, 'priceLimit'])->name('priceLimit');
});

/** Admin */
Route::prefix('admin')->name('admin.')->group(function () {
    /** Formulário de Login */
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.do');
    /** Rotas Protegidas */
    Route::middleware(['auth'])->group(function () {
        /** Dashboard Home */
        Route::get('home', [AuthController::class, 'home'])->name('home');
        /** Usuários */
        Route::get('users/team', [UserController::class, 'team'])->name('users.team');
        Route::resource('users', UserController::class);
        /** Empresas */
        Route::resource('companies', CompanyController::class);
        /** Imóveis */
        Route::post('properties/image-set-cover', [PropertyController::class, 'imageSetCover'])->name('properties.imageSetCover');
        Route::delete('properties/image-remove', [PropertyController::class, 'imageRemove'])->name('properties.imageRemove');
        Route::resource('properties', PropertyController::class);
        /** Contratos */
        Route::post('contracts/get-data-owner', [ContractController::class, 'getDataOwner'])->name('contracts.getDataOwner');
        Route::post('contracts/get-data-acquirer', [ContractController::class, 'getDataAcquirer'])->name('contracts.getDataAcquirer');
        Route::post('contracts/get-data-property', [ContractController::class, 'getDataProperty'])->name('contracts.getDataProperty');
        Route::resource('contracts', ContractController::class);

        /** ACL */
        /** Permissões */
        Route::resource('permission', PermissionController::class);

        /** Perfis */
        Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permissions');
        Route::put('role/{role}/permission/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
        Route::resource('role', RoleController::class);
    });
    /** Rota de logout */
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

