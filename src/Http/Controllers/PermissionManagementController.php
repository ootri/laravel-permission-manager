<?php

namespace Ootri\PermissionManager\Http\Controllers;

class PermissionManagementController 
{
    public static function index()
    {
        return view('Ootri\PermissionManager::permissions.index');
    }
}
