# Ootri Permission Manager

## Overview

Ootri Permission Manager is a very simple permission and role management dashboard for spatie/laravel-permission designed to work with the TALL stack, specifically Laravel Jetstream (optional). It leverages the Spatie Laravel Permission package to provide a user-friendly interface for managing users, roles, and permissions.

While it was designed to integrate with Jetstream, it can also be used standalone within any TALL stack application or a custom dashboards.

## Installation

Install via Composer:
```bash
composer require ootri/laravel-permission-manager
```

## Usage

### Option 1: Permissions already set

Add this if you've already setup permissions using spatie/laravel-permission:
```php
Route::group(['middleware' => ['can:admin']], function () {
    Route::get('/permissions', [\Ootri\PermissionManager\Http\Controllers\PermissionManagementController::class, 'index'])->name('permissions.index');
});
```

### Option 2: Restrict to auth/user

If you haven't yet created any permissions/roles:
```php
// Restrict to any logged in user
Route::middleware(['auth'])->group(function () {
    Route::get('/permissions', [\Ootri\PermissionManager\Http\Controllers\PermissionManagementController::class, 'index'])->name('permissions.index');
});

// Or specify a user by email address
Route::middleware(['auth'])->group(function () {
    Route::get('/permissions', function () {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->email === 'test@domain.com') {
            return app()->call([\Ootri\PermissionManager\Http\Controllers\PermissionManagementController::class, 'index']);
        }
        abort(403, 'Unauthorized');
    })->name('permissions.index');
});
```
IMPORTANT: This is just temporary until admin permissions/roles are created, then change it to Option 1.

### Option 3: Using Livewire Components Directly

If you prefer to integrate the permission management tools directly into an existing dashboard or custom UI, you can include the Livewire components directly in your Blade templates:

```php
@livewire('ootri-permission-management')
@livewire('ootri-user-management')
```

This approach removes the dependency on Jetstream, allowing flexibility to integrate into any other app based on the TALL stack.

## Features

- User Management: Add, view, and remove users.
- Role Management: Create, assign, and revoke roles.
- Permission Management: Create, assign, and revoke permissions.
- Direct User Permissions: Assign/revoke permissions directly to/from users.
- Clear Overview: Display current assignments for users, roles, and permissions.

This package is intended to be and remain simple.