<div class="p-6 bg-white rounded-md shadow-md">
    <h2 class="text-xl font-bold mb-4">User Management</h2>

    <!-- Create User Form -->
    <div class="mb-6">
        <h3 class="font-semibold">Add User</h3>
        <input type="text" wire:model="name" placeholder="Name" class="border p-2 mr-2 mb-2 w-full">
        <input type="email" wire:model="email" placeholder="Email" class="border p-2 mr-2 mb-2 w-full">
        <input type="password" wire:model="password" placeholder="Password" class="border p-2 mr-2 mb-2 w-full">
        <button wire:click="createUser" class="bg-green-500 text-white p-2 rounded w-full">Add User</button>
    </div>

    <!-- User List -->
    <h3 class="font-semibold">Users</h3>
    @if (session()->has('message'))
        <div class="text-green-500 mb-2">{{ session('message') }}</div>
    @endif

    <ul>
        @foreach($users as $user)
            <li class="flex justify-between items-center mt-2">
                {{ $user->name }} ({{ $user->email }})
                <button wire:click="deleteUser({{ $user->id }})" class="text-red-500">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
