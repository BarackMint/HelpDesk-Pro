<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tickets
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters & Search --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('tickets.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        {{-- Search --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input
                                type="text"
                                name="search"
                                value="{{ $filters['search'] ?? '' }}"
                                placeholder="Search tickets..."
                                class="w-full border-gray-300 rounded-md shadow-sm"
                            />
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Statuses</option>
                                @foreach(['open', 'in_progress', 'resolved', 'closed'] as $status)
                                    <option value="{{ $status }}" {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Priority --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                            <select name="priority" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Priorities</option>
                                @foreach(['low', 'medium', 'high', 'critical'] as $priority)
                                    <option value="{{ $priority }}" {{ ($filters['priority'] ?? '') === $priority ? 'selected' : '' }}>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="mt-4 flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Filter
                        </button>
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tickets Table --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Create Button --}}
                    @if(auth()->user()->isEmployee())
                        <div class="mb-4">
                            <a href="{{ route('tickets.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                                + New Ticket
                            </a>
                        </div>
                    @endif

                    @if($tickets->isEmpty())
                        <p class="text-gray-500">No tickets found.</p>
                    @else
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Title</th>
                                    <th class="px-4 py-3">Category</th>
                                    <th class="px-4 py-3">Priority</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Created</th>
                                    <th class="px-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($tickets as $ticket)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $ticket->id }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $ticket->title }}</td>
                                        <td class="px-4 py-3">{{ $ticket->category->name ?? '—' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $ticket->priority === 'critical' ? 'bg-red-100 text-red-700' : '' }}
                                                {{ $ticket->priority === 'high' ? 'bg-orange-100 text-orange-700' : '' }}
                                                {{ $ticket->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $ticket->priority === 'low' ? 'bg-green-100 text-green-700' : '' }}
                                            ">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $ticket->status === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $ticket->status === 'resolved' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-700' : '' }}
                                            ">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:underline">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $tickets->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>