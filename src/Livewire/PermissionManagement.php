<?php

namespace Ootri\PermissionManager\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionManagement extends Component
{
    public $roles, $permissions, $users;
    public $roleName, $permissionName;
    public $selectedUser, $selectedRole, $selectedPermission;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->roles = Role::with('permissions')->get(); // Include permissions in roles
        $this->permissions = Permission::all();
        $this->users = User::with('roles', 'permissions')->get(); // Include roles and permissions in users
    }

    // Role CRUD
    public function createRole()
    {
        Role::create(['name' => $this->roleName]);
        $this->roleName = '';
        $this->loadData();
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);

        if (!$role) {
            session()->flash('error', 'Role not found.');
            return;
        }

        if ($role->users()->exists()) {
            session()->flash('error', 'Cannot delete role because it is assigned to users.');
            return;
        }

        // Check if role has any permissions
        if ($role->permissions()->exists()) {
            session()->flash('error', 'Cannot delete role because it has permissions assigned.');
            return;
        }

        $role->delete();
        $this->loadData();
        session()->flash('message', 'Role deleted successfully.');
    }

    // Permission CRUD
    public function createPermission()
    {
        Permission::create(['name' => $this->permissionName]);
        $this->permissionName = '';
        $this->loadData();
    }

    public function deletePermission($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            session()->flash('error', 'Permission not found.');
            return;
        }

        // Check if permission is assigned to any roles
        if ($permission->roles()->exists()) {
            session()->flash('error', 'Cannot delete permission because it is assigned to roles.');
            return;
        }

        // Check if permission is assigned directly to any users
        if ($permission->users()->exists()) {
            session()->flash('error', 'Cannot delete permission because it is assigned directly to users.');
            return;
        }

        $permission->delete();
        $this->loadData();
        session()->flash('message', 'Permission deleted successfully.');
    }

    // Assign Role to User
    public function assignRole()
    {
        $user = User::find($this->selectedUser);
        $role = Role::find($this->selectedRole);
    
        if ($user && $role) {

            // Check if role is already assigned to user
            if ($user->hasRole($role->name)) {
                session()->flash('error', 'Role is already assigned to this user.');
                return;
            }

            $user->assignRole($role->name);
            $this->loadData();
            session()->flash('message', 'Role assigned successfully.');
        } else {
            session()->flash('error', 'Invalid user or role selected.');
        }
    }

    public function revokeRole()
    {
        $user = User::find($this->selectedUser);
        $role = Role::find($this->selectedRole);

        if ($user && $role) {

            // Check if role is already assigned to user
            if (!$user->hasRole($role->name)) {
                session()->flash('error', 'Role is not assigned to this user.');
                return;
            }

            $user->removeRole($role->name);
            $this->loadData();
            session()->flash('message', 'Role revoked successfully.');
        } else {
            session()->flash('error', 'Invalid user or role selected.');
        }
    }

    // Assign Permission to Role
    public function assignPermission()
    {
        $role = Role::find($this->selectedRole);
        $permission = Permission::find($this->selectedPermission);
    
        if ($role && $permission) {

            // Check if permission is already assigned to role
            if ($role->hasPermissionTo($permission->name)) {
                session()->flash('error', 'Permission is already assigned to this role.');
                return;
            }

            $role->givePermissionTo($permission->name);
            $this->loadData();
            session()->flash('message', 'Permission assigned successfully.');
        } else {
            session()->flash('error', 'Invalid role or permission selected.');
        }
    }

    public function revokePermission()
    {
        $role = Role::find($this->selectedRole);
        $permission = Permission::find($this->selectedPermission);
    
        if ($role && $permission) {

            // Check if permission is already assigned to role
            if (!$role->hasPermissionTo($permission->name)) {
                session()->flash('error', 'Permission is not assigned to this role.');
                return;
            }

            $role->revokePermissionTo($permission->name);
            $this->loadData();
            session()->flash('message', 'Permission revoked successfully.');
        } else {
            session()->flash('error', 'Invalid role or permission selected.');
        }
    }

    public function getUserRoles($userId)
    {
        $user = $this->users->find($userId);
        return $user ? $user->roles->pluck('name')->toArray() : [];
    }

    public function getRolePermissions($roleId)
    {
        $role = $this->roles->find($roleId);
        return $role ? $role->permissions->pluck('name')->toArray() : [];
    }

    public function assignUserPermission()
    {
        $user = User::find($this->selectedUser);
        $permission = Permission::find($this->selectedPermission);

        if ($user && $permission) {
            if ($user->hasPermissionTo($permission->name)) {
                session()->flash('error', 'Permission is already assigned to this user.');
                return;
            }

            $user->givePermissionTo($permission->name);
            $this->loadData();
            session()->flash('message', 'Permission assigned to user successfully.');
        } else {
            session()->flash('error', 'Invalid user or permission selected.');
        }
    }

    public function revokeUserPermission()
    {
        $user = User::find($this->selectedUser);
        $permission = Permission::find($this->selectedPermission);

        if ($user && $permission) {
            if (!$user->hasPermissionTo($permission->name)) {
                session()->flash('error', 'Permission is not assigned to this user.');
                return;
            }

            $user->revokePermissionTo($permission->name);
            $this->loadData();
            session()->flash('message', 'Permission revoked from user successfully.');
        } else {
            session()->flash('error', 'Invalid user or permission selected.');
        }
    }

    public function render()
    {
        return view('Ootri\PermissionManager::livewire.permission-management');
    }
}
