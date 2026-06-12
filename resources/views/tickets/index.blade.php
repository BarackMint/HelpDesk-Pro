<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base font-semibold text-gray-900">Tickets</h1>
                <p class="text-sm text-gray-400 mt-0.5">Manage and track support tickets</p>
            </div>
            @if(auth()->user()->isEmployee())
                <a href="{{ route('tickets.create') }}"
                    class="px-4 py-2 bg-gray-900 text-white text-sm font-medium
                    rounded-md hover:bg-gray-700 transition-colors">
                    + New Ticket
                </a>
            @endif
        </div>
    </x-slot>

    <div class="space-y-4">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700
                rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <div class="bg-white rounded-lg border border-gray-100 p-5">
            <form method="GET" action="{{ route('tickets.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div>
                        <label class="block text-xs font-medium text-gray-400
                            uppercase tracking-wide mb-1.5">Search</label>
                        <input type="text" name="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Search tickets..."
                            class="w-full border-gray-200 rounded-md text-sm
                            focus:ring-gray-900 focus:border-gray-900"/>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400
                            uppercase tracking-wide mb-1.5">Status</label>
                        <select name="status" class="w-full border-gray-200 rounded-md
                            text-sm focus:ring-gray-900 focus:border-gray-900">
                            <option value="">All Statuses</option>
                            @foreach(['open', 'in_progress', 'resolved', 'closed'] as $status)
                                <option value="{{ $status }}"
                                    {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400
                            uppercase tracking-wide mb-1.5">Priority</label>
                        <select name="priority" class="w-full border-gray-200 rounded-md
                            text-sm focus:ring-gray-900 focus:border-gray-900">
                            <option value="">All Priorities</option>
                            @foreach(['low', 'medium', 'high', 'critical'] as $priority)
                                <option value="{{ $priority }}"
                                    {{ ($filters['priority'] ?? '') === $priority
                                        ? 'selected' : '' }}>
                                    {{ ucfirst($priority) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400
                            uppercase tracking-wide mb-1.5">Category</label>
                        <select name="category_id" class="w-full border-gray-200 rounded-md
                            text-sm focus:ring-gray-900 focus:border-gray-900">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ ($filters['category_id'] ?? '') == $category->id
                                        ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="mt-4 flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-gray-900 text-white text-sm font-medium
                        rounded-md hover:bg-gray-700 transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('tickets.index') }}"
                        class="px-4 py-2 bg-white text-gray-600 text-sm font-medium
                        rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg border border-gray-100">
            @if($tickets->isEmpty())
                <div class="px-5 py-12 text-center">
                    <p class="text-sm font-medium text-gray-900 mb-1">No tickets found</p>
                    <p class="text-sm text-gray-400">
                        Try adjusting your filters or create a new ticket.
                    </p>
                </div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">#</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Title</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Category</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Priority</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Created</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-gray-400">{{ $ticket->id }}</td>
                                <td class="px-5 py-3 font-medium text-gray-900">
                                    {{ $ticket->title }}
                                </td>
                                <td class="px-5 py-3 text-gray-500">
                                    {{ $ticket->category->name ?? '—' }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5
                                        rounded text-xs font-medium
                                        {{ $ticket->priority === 'critical'
                                            ? 'bg-red-50 text-red-700' : '' }}
                                        {{ $ticket->priority === 'high'
                                            ? 'bg-orange-50 text-orange-700' : '' }}
                                        {{ $ticket->priority === 'medium'
                                            ? 'bg-amber-50 text-amber-700' : '' }}
                                        {{ $ticket->priority === 'low'
                                            ? 'bg-gray-100 text-gray-500' : '' }}
                                    ">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5
                                        rounded text-xs font-medium
                                        {{ $ticket->status === 'open'
                                            ? 'bg-blue-50 text-blue-700' : '' }}
                                        {{ $ticket->status === 'in_progress'
                                            ? 'bg-amber-50 text-amber-700' : '' }}
                                        {{ $ticket->status === 'resolved'
                                            ? 'bg-emerald-50 text-emerald-700' : '' }}
                                        {{ $ticket->status === 'closed'
                                            ? 'bg-gray-100 text-gray-500' : '' }}
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-400">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                        class="text-xs text-gray-400 hover:text-gray-700
                                        transition-colors">
                                        View →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $tickets->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>