<?php

use Illuminate\Support\Facades\Route;

// Route::middleware(['auth'])->group(function () {
//     Route::get('/permissions', [\Ootri\PermissionManager\Http\Controllers\PermissionManagementController::class, 'index'])->name('permissions.index');
// });

// OR

// Route::group(['middleware' => ['can:admin']], function () {
//     Route::get('/permissions', [\Ootri\PermissionManager\Http\Controllers\PermissionManagementController::class, 'index'])->name('permissions.index');
// });

// OR

// Route::middleware(['auth'])->group(function () {
//     Route::get('/permissions', function () {
//         if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->email === 'test@domain.com') {
//             return app()->call([\Ootri\PermissionManager\Http\Controllers\PermissionManagementController::class, 'index']);
//         }
//         abort(403, 'Unauthorized');
//     })->name('permissions.index');
// });