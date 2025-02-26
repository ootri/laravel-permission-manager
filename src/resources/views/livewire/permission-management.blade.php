<div class="p-6 bg-white rounded-md shadow-md">

    <h2 class="text-xl font-bold mb-4">User, Role & Permission Management</h2>

    <!-- Roles Management -->
    <div class="mb-6">
        <h3 class="font-semibold">Roles</h3>
        <input type="text" wire:model="roleName" placeholder="Role Name" class="border p-2 mr-2">
        <button wire:click="createRole" class="bg-blue-500 text-white p-2 rounded-sm">Add Role</button>
        
        <ul>
            @foreach($roles as $role)
                <li class="flex justify-between items-center mt-2 bg-gray-100 p-2 rounded-sm">
                    {{ $role->name }}
                    <button wire:click="deleteRole({{ $role->id }})" class="text-red-500">Delete</button>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Permissions Management -->
    <div class="mb-6">
        <h3 class="font-semibold">Permissions</h3>
        <input type="text" wire:model="permissionName" placeholder="Permission Name" class="border p-2 mr-2">
        <button wire:click="createPermission" class="bg-green-500 text-white p-2 rounded-sm">Add Permission</button>
        
        <ul>
            @foreach($permissions as $permission)
                <li class="flex justify-between items-center mt-2 bg-gray-100 p-2 rounded-sm">
                    {{ $permission->name }}
                    <button wire:click="deletePermission({{ $permission->id }})" class="text-red-500">Delete</button>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Assign Roles to Users -->
    <div class="mb-6 p-4 border rounded-md bg-gray-50">
        <h3 class="font-semibold">Assign Roles to Users</h3>
        <select wire:model="selectedUser" class="border p-2 mr-2">
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <select wire:model="selectedRole" class="border p-2 mr-2">
            <option value="">Select Role</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
        
        <button wire:click="assignRole" class="bg-yellow-500 text-white p-2 rounded-sm">Assign Role</button>
        <button wire:click="revokeRole" class="bg-red-500 text-white p-2 rounded-sm">Revoke Role</button>

        <h3 class="font-semibold mt-6">Current User Role Assignments</h3>
        <div class="mt-2">
            <ul>
                @foreach($users as $user)
                    <li class="mb-2 ml-4">
                        <strong>{{ $user->name }}</strong> – 
                        @if($user->roles->isNotEmpty())
                            {{ $user->roles->pluck('name')->join(', ') }}
                        @else
                            <span class="text-gray-500">No Roles Assigned</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Assign Permissions to Roles -->
    <div class="mb-6 p-4 border rounded-md bg-gray-50">
        <h3 class="font-semibold">Assign Permissions to Roles</h3>
        <select wire:model="selectedRole" class="border p-2 mr-2">
            <option value="">Select Role</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>

        <select wire:model="selectedPermission" class="border p-2 mr-2">
            <option value="">Select Permission</option>
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
            @endforeach
        </select>
        
        <button wire:click="assignPermission" class="bg-blue-500 text-white p-2 rounded-sm">Assign Permission</button>
        <button wire:click="revokePermission" class="bg-red-500 text-white p-2 rounded-sm">Revoke Permission</button>

        <h3 class="font-semibold mt-6">Current Role Permission Assignments</h3>
        <div class="mt-2">
            <ul>
                @foreach($roles as $role)
                    <li class="mb-2 ml-4">
                        <strong>{{ $role->name }}</strong> – 
                        @if($role->permissions->isNotEmpty())
                            {{ $role->permissions->pluck('name')->join(', ') }}
                        @else
                            <span class="text-gray-500">No Permissions Assigned</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Assign Permissions Directly to Users -->
    <div class="mb-6 p-4 border rounded-md bg-gray-50">
        <h3 class="font-semibold">Assign Permissions Directly to Users</h3>
        <!-- Select User Dropdown -->
        <select wire:model="selectedUser" class="border p-2 mr-2">
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <!-- Select Permission Dropdown -->
        <select wire:model="selectedPermission" class="border p-2 mr-2">
            <option value="">Select Permission</option>
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
            @endforeach
        </select>

        <!-- Assign and Revoke Buttons -->
        <button wire:click="assignUserPermission" class="bg-blue-500 text-white p-2 rounded-sm">Assign Permission</button>
        <button wire:click="revokeUserPermission" class="bg-red-500 text-white p-2 rounded-sm">Revoke Permission</button>


        <h3 class="font-semibold mt-6">Current User Permission Assignments (Direct)</h3>
        <div class="mt-2">
            <ul>
                @foreach($users as $user)
                    <li class="mb-2 ml-4">
                        <strong>{{ $user->name }}</strong> – 
                        @if($user->permissions->isNotEmpty())
                            {{ $user->permissions->pluck('name')->join(', ') }}
                        @else
                            <span class="text-gray-500">No Direct Permissions Assigned</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

    <!-- Display Success and Error Messages -->
    <div class="mt-6">
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
    </div>

</div>
