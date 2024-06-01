<?php

use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\AdminIngredientsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AdminMicroorganismsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyOrdersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodTechnologistsController;
use App\Http\Controllers\EmployeeRegistrationController;
use App\Http\Controllers\EmployeeLoginController;
use App\Http\Controllers\FoodTechnologistController;
use App\Http\Controllers\ManagerAssignProductToFoodTechnologistController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\SecretaryAssignOrderToManagerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\FoodTechnologistProductTestController;
use App\Http\Controllers\ManagerTestReviewController;
use App\Http\Controllers\SecretaryFinishedOrdersController;
use App\Http\Controllers\StatisticsController;

// Trasy dostępne bez logowania
Route::get('/', function () {
    return view('welcome');
})->name('Mainpage');

Route::get('/api/statistics', [StatisticsController::class, 'getStatistics']);

Route::get('/employee/register', [EmployeeRegistrationController::class, 'showRegistrationForm'])->name('employee.register');
Route::get('/employee/register/{token}', [EmployeeRegistrationController::class, 'showRegistrationForm'])->name('employee.registration.form');
Route::post('/employee/register', [EmployeeRegistrationController::class, 'register']);

Route::get('employee/login', [EmployeeLoginController::class, 'showLoginForm'])->name('login');
Route::post('employee/login', [EmployeeLoginController::class, 'login']);

Auth::routes();

Route::view('/login', 'auth.login')->name('login');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/order/create', [CompanyOrdersController::class, 'create'])->name('order.create');
Route::post('/order/store', [CompanyOrdersController::class, 'store'])->name('order.store');
Route::post('/order/check-nip', [CompanyOrdersController::class, 'checkNip'])->name('order.checkNip');

Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
// Trasy wymagające autoryzacji
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update', [UserController::class, 'update'])->name('user.update');

    // Trasy dla sekretarki
    Route::middleware('can:isSecretary')->group(function () {
        Route::get('/secretary/orders/finished', [SecretaryFinishedOrdersController::class, 'index'])->name('secretary.orders.finished');
        Route::get('/secretary/orders/report/{id}', [SecretaryFinishedOrdersController::class, 'generateOrderReportPDF'])->name('secretary.orders.report');
        Route::get('product/images/{productId}', [SecretaryFinishedOrdersController::class, 'downloadProductImages'])->name('download.product.images');

         Route::get('secretary/orders/assign/{orderId}', [SecretaryAssignOrderToManagerController::class, 'showAssignForm'])->name('secretary.orders.showAssignForm');
        Route::post('secretary/orders/assign/{orderId}', [SecretaryAssignOrderToManagerController::class, 'assign'])->name('secretary.orders.assign');

        Route::get('secretary/orders/assignable', [SecretaryController::class, 'showAssignableOrders'])->name('secretary.orders.assignable');
        Route::get('/managers/{managerId}/details/{productCount}', [SecretaryAssignOrderToManagerController::class, 'getManagerDetails'])->name('managers.details');


        Route::get('/link/create', function () {
            // Logika dla tworzenia linku
        })->name('link.create');
    });

    // Trasy dla managera
    Route::middleware('can:isManager')->group(function () {
        Route::get('manager/orders/overview', function () {
            // Logika dla przeglądu zamówień
        })->name('orders.overview');

        Route::get('manager/order_products/assign', [ManagerController::class, 'showAssignableProducts'])->name('manager.products.assignable');
        Route::get('manager/products/assign/{productId}', [ManagerAssignProductToFoodTechnologistController::class, 'showAssignForm'])->name('manager.products.assign');
        Route::post('manager/products/assign/{productId}', [ManagerAssignProductToFoodTechnologistController::class, 'assign'])->name('manager.products.assign');
        Route::get('/food-technologists/{foodTechnologistId}/details', [ManagerAssignProductToFoodTechnologistController::class, 'getFoodTechnologistDetails'])->name('food-technologists.details');

        Route::get('manager/tests/review', [ManagerTestReviewController::class, 'review'])->name('tests.review');
        Route::post('manager/tests/accept/{id}', [ManagerTestReviewController::class, 'accept'])->name('tests.accept');
        Route::post('manager/tests/decline/{id}', [ManagerTestReviewController::class, 'decline'])->name('tests.decline');
        Route::post('manager/tests/reassign/{id}', [ManagerTestReviewController::class, 'reassign'])->name('tests.reassign');
        Route::get('manager/active-employees', [ManagerTestReviewController::class, 'getActiveEmployees'])->name('active.employees');


        Route::get('manager/tests/overview', function () {
            // Logika dla przeglądu wszystkich testów
        })->name('tests.overview');

        Route::get('manager/food_technologist/view', function () {
            // Logika dla przeglądu technologów żywności
        })->name('food_technologist.view');
    });

    // Trasy dla technologa żywności
Route::middleware('can:isFoodTechnologist')->group(function () {
    Route::get('food_technologist/products/overview', function () {
        // Logika dla przeglądu produktów
    })->name('food_technologist.products.overview');

    Route::get('food_technologist/products/assign', function () {
        // Logika dla przypisania produktów
    })->name('food_technologist.products.manage');

    Route::get('food_technologist/products/assigned', [FoodTechnologistController::class, 'manage'])->name('food_technologist.products.assigned');
    Route::get('/food-technologist/product-test/{id_product}', [FoodTechnologistProductTestController::class, 'show'])->name('foodTechnologistProductTest.show');
    Route::put('/food-technologist/product-test/{id_product}', [FoodTechnologistProductTestController::class, 'update'])->name('foodTechnologistProductTest.update');

});

    // Trasy dla administratora
    Route::middleware('can:isAdmin')->group(function () {
        Route::get('/admin/employees', [AdministratorController::class, 'employees'])->name('admin.employees');
        Route::get('/admin/employees/{employee}', [AdministratorController::class, 'show'])->name('admin.show');
        Route::post('/admin/employees', [AdministratorController::class, 'store'])->name('admin.store');
        Route::get('/admin/employees/{employee}/edit', [AdministratorController::class, 'edit'])->name('admin.edit');
        Route::put('/admin/employees/{employee}', [AdministratorController::class, 'update'])->name('admin.update');
        Route::post('/admin/employees/{employee}/assign-position', [AdministratorController::class, 'assignPosition'])->name('admin.assignPosition');
        Route::post('/admin/employees/{employee}/assign-manager', [AdministratorController::class, 'assignManager'])->name('admin.assignManager');
        Route::post('/admin/employees/{employee}/change-status', [AdministratorController::class, 'changeStatus'])->name('admin.changeStatus');
        Route::delete('/admin/employees/{employee}', [AdministratorController::class, 'destroy'])->name('admin.destroy');
        Route::post('/admin/generateTemporaryLink', [EmployeeRegistrationController::class, 'generateTemporaryLink'])->name('admin.generateTemporaryLink');


        Route::get('/admin/orders', [AdministratorController::class, 'orders'])->name('admin.orders');
        Route::get('/admin/microorganisms', [AdministratorController::class, 'microorganisms'])->name('admin.microorganisms');

        Route::prefix('admin')->group(function () {
            Route::get('/company', [AdminCompanyController::class, 'index'])->name('admin.company.index');
            Route::get('/company/create', [AdminCompanyController::class, 'create'])->name('admin.company.create');
            Route::post('/company', [AdminCompanyController::class, 'store'])->name('admin.company.store');
            Route::get('/company/{id}/edit', [AdminCompanyController::class, 'edit'])->name('admin.company.edit');
            Route::put('/company/{id}', [AdminCompanyController::class, 'update'])->name('admin.company.update');
            Route::delete('/company/{id}', [AdminCompanyController::class, 'destroy'])->name('admin.company.destroy');

            Route::post('/company/{companyId}/order', [AdminCompanyController::class, 'storeOrder'])->name('admin.company.storeOrder');
            Route::get('order/{order}/edit', [AdminCompanyController::class, 'editOrder'])->name('company.order.edit');
            Route::put('order/{order}', [AdminCompanyController::class, 'updateOrder'])->name('company.order.update');
            Route::delete('order/{order}', [AdminCompanyController::class, 'destroyOrder'])->name('company.order.destroy');

            Route::post('/company/{orderId}/product', [AdminCompanyController::class, 'storeProduct'])->name('admin.company.storeProduct');
            Route::get('product/{product}/edit', [AdminCompanyController::class, 'editProduct'])->name('company.product.edit');
            Route::put('product/{product}', [AdminCompanyController::class, 'updateProduct'])->name('company.product.update');
            Route::delete('product/{product}', [AdminCompanyController::class, 'destroyProduct'])->name('company.product.destroy');




            Route::get('/ingredients', [AdminIngredientsController::class, 'index'])->name('admin.ingredients');
        Route::post('/ingredients', [AdminIngredientsController::class, 'store'])->name('admin.ingredients.store');
        Route::put('/ingredients/{id}', [AdminIngredientsController::class, 'update'])->name('admin.ingredients.update');
        Route::delete('/ingredients/{id}', [AdminIngredientsController::class, 'destroy'])->name('admin.ingredients.destroy');

        Route::get('/microorganisms', [AdminMicroorganismsController::class, 'index'])->name('admin.microorganisms'); // Add this line
    Route::post('/microorganisms', [AdminMicroorganismsController::class, 'store'])->name('admin.microorganisms.store'); // Add this line
    Route::put('/microorganisms/{id}', [AdminMicroorganismsController::class, 'update'])->name('admin.microorganisms.update'); // Add this line
    Route::delete('/microorganisms/{id}', [AdminMicroorganismsController::class, 'destroy'])->name('admin.microorganisms.destroy'); // Add this line


        });
    });

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});
