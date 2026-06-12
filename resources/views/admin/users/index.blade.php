<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-base font-semibold text-gray-900">Users</h1>
            <p class="text-sm text-gray-400 mt-0.5">Manage user accounts and roles</p>
        </div>
    </x-slot>

    <div class="space-y-4">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100
                text-emerald-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-100
                text-red-700 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filters --}}
        <div class="bg-white rounded-lg border border-gray-100 p-5">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400
                            uppercase tracking-wide mb-1.5">Search</label>
                        <input type="text" name="search"
                            value="{{ request('search') }}"
                            placeholder="Name or email..."
                            class="w-full border-gray-200 rounded-md text-sm
                            focus:ring-gray-900 focus:border-gray-900"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400
                            uppercase tracking-wide mb-1.5">Role</label>
                        <select name="role" class="w-full border-gray-200 rounded-md
                            text-sm focus:ring-gray-900 focus:border-gray-900">
                            <option value="">All Roles</option>
                            @foreach(['employee', 'agent', 'admin'] as $role)
                                <option value="{{ $role }}"
                                    {{ request('role') === $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-900 text-white text-sm font-medium
                            rounded-md hover:bg-gray-700 transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 bg-white text-gray-600 text-sm font-medium
                            rounded-md border border-gray-200 hover:bg-gray-50
                            transition-colors">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Users Table --}}
        <div class="bg-white rounded-lg border border-gray-100">
            @if($users->isEmpty())
                <div class="px-5 py-12 text-center">
                    <p class="text-sm text-gray-400">No users found.</p>
                </div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">#</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Name</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Email</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Role</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Joined</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-gray-400">{{ $user->id }}</td>
                                <td class="px-5 py-3 font-medium text-gray-900">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="ml-1 text-xs text-gray-400">(you)</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $user->email }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5
                                        rounded text-xs font-medium
                                        {{ $user->isAdmin()
                                            ? 'bg-red-50 text-red-700' : '' }}
                                        {{ $user->isAgent()
                                            ? 'bg-blue-50 text-blue-700' : '' }}
                                        {{ $user->isEmployee()
                                            ? 'bg-gray-100 text-gray-500' : '' }}
                                    ">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-400">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-xs text-gray-400 hover:text-gray-700
                                        transition-colors">
                                        Edit →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>