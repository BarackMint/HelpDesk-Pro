<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User — {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:underline">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- User Info --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium text-gray-800">Name:</span>
                        {{ $user->name }}
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        <span class="font-medium text-gray-800">Email:</span>
                        {{ $user->email }}
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        <span class="font-medium text-gray-800">Current Role:</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : '' }}
                            {{ $user->isAgent() ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $user->isEmployee() ? 'bg-gray-100 text-gray-700' : '' }}
                        ">
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>
                </div>

                {{-- Role Form --}}
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Assign New Role <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="role"
                            class="w-full border-gray-300 rounded-md shadow-sm
                                @error('role') border-red-500 @enderror"
                        >
                            @foreach(['employee', 'agent', 'admin'] as $role)
                                <option value="{{ $role }}"
                                    {{ old('role', $user->role) === $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Self Edit Warning --}}
                    @if($user->id === auth()->id())
                        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                            <p class="text-sm text-yellow-700">
                                ⚠️ You are editing your own account. You cannot change your own role.
                            </p>
                        </div>
                    @endif

                    <div class="flex items-center gap-4 mt-6">
                        <button
                            type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500
                                {{ $user->id === auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}
                        >
                            Update Role
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>