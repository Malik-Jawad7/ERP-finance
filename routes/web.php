<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get("/", [DashboardController::class, "index"])->name("dashboard")->middleware("auth");
Route::delete("clients/destroy-all", [ClientController::class, "destroyAll"])->name("clients.destroyAll");
Route::resource("clients", ClientController::class);
Route::delete("invoices/destroy-all", [InvoiceController::class, "destroyAll"])->name("invoices.destroyAll");
Route::resource("invoices", InvoiceController::class);
Route::delete("expenses/destroy-all", [ExpenseController::class, "destroyAll"])->name("expenses.destroyAll");
Route::resource("expenses", ExpenseController::class);
Route::delete("payrolls/destroy-all", [\App\Http\Controllers\PayrollController::class, "destroyAll"])->name("payrolls.destroyAll");
Route::resource("payrolls", \App\Http\Controllers\PayrollController::class);
Route::delete("vendors/destroy-all", [\App\Http\Controllers\VendorController::class, "destroyAll"])->name("vendors.destroyAll");
Route::resource("vendors", \App\Http\Controllers\VendorController::class);
Route::delete("accounts/destroy-all", [\App\Http\Controllers\AccountController::class, "destroyAll"])->name("accounts.destroyAll");
Route::resource("accounts", \App\Http\Controllers\AccountController::class);
Route::delete("transactions/destroy-all", [\App\Http\Controllers\TransactionController::class, "destroyAll"])->name("transactions.destroyAll");
Route::resource("transactions", \App\Http\Controllers\TransactionController::class);
Route::delete("departments/destroy-all", [\App\Http\Controllers\DepartmentController::class, "destroyAll"])->name("departments.destroyAll");
Route::resource("departments", \App\Http\Controllers\DepartmentController::class);
Route::delete("employees/destroy-all", [\App\Http\Controllers\EmployeeController::class, "destroyAll"])->name("employees.destroyAll");
Route::resource("employees", \App\Http\Controllers\EmployeeController::class);
Route::delete("projects/destroy-all", [\App\Http\Controllers\ProjectController::class, "destroyAll"])->name("projects.destroyAll");
Route::resource("projects", \App\Http\Controllers\ProjectController::class);
Route::get("/settings", [SettingController::class, "index"])->name("settings");
Route::post("/settings", [SettingController::class, "update"])->name("settings.update");

Route::post("/notifications/read", [App\Http\Controllers\NotificationController::class, "markAsRead"])->name("notifications.read");
Route::post("/notifications/clear", [App\Http\Controllers\NotificationController::class, "clearAll"])->name("notifications.clear");

Route::resource("payments", \App\Http\Controllers\PaymentController::class)->except(["edit", "update"]);
Route::get("invoices/{invoice}/pay", [\App\Http\Controllers\PaymentController::class, "create"])->name("invoices.pay");

require __DIR__."/auth.php";