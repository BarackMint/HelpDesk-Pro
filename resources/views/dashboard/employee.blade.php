<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-base font-semibold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-400 mt-0.5">Track and manage your support tickets</p>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Welcome Banner --}}
        <div class="bg-gray-900 rounded-lg p-6 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-semibold text-white">
                    Welcome back, {{ auth()->user()->name }}
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    Need help? Submit a ticket and we'll get back to you.
                </p>
            </div>
            <a href="{{ route('tickets.create') }}"
                class="shrink-0 px-4 py-2 bg-white text-gray-900 text-sm font-medium
                rounded-md hover:bg-gray-100 transition-colors">
                + New Ticket
            </a>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white rounded-lg border border-gray-100 p-5">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                    My Tickets
                </p>
                <p class="text-2xl font-semibold text-gray-900 mt-2">
                    {{ $stats['total_tickets'] }}
                </p>
            </div>

            <div class="bg-white rounded-lg border border-gray-100 p-5">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                    Open
                </p>
                <p class="text-2xl font-semibold text-blue-600 mt-2">
                    {{ $stats['open_tickets'] }}
                </p>
            </div>

            <div class="bg-white rounded-lg border border-gray-100 p-5">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                    In Progress
                </p>
                <p class="text-2xl font-semibold text-amber-500 mt-2">
                    {{ $stats['in_progress'] }}
                </p>
            </div>

            <div class="bg-white rounded-lg border border-gray-100 p-5">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                    Resolved
                </p>
                <p class="text-2xl font-semibold text-emerald-600 mt-2">
                    {{ $stats['resolved_tickets'] }}
                </p>
            </div>

        </div>

        {{-- Recent Tickets --}}
        <div class="bg-white rounded-lg border border-gray-100">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <p class="text-sm font-medium text-gray-900">My Recent Tickets</p>
                <a href="{{ route('tickets.index') }}"
                    class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    View all →
                </a>
            </div>

            @if($recentTickets->isEmpty())
                <div class="px-5 py-12 text-center">
                    <p class="text-sm font-medium text-gray-900 mb-1">No tickets yet</p>
                    <p class="text-sm text-gray-400 mb-4">
                        Submit your first ticket and track its progress here.
                    </p>
                    <a href="{{ route('tickets.create') }}"
                        class="px-4 py-2 bg-gray-900 text-white text-sm font-medium
                        rounded-md hover:bg-gray-700 transition-colors">
                        Create Ticket
                    </a>
                </div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-400
                                uppercase tracking-wide">#</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-400
                                uppercase tracking-wide">Title</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-400
                                uppercase tracking-wide">Category</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-400
                                uppercase tracking-wide">Assigned To</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-400
                                uppercase tracking-wide">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-400
                                uppercase tracking-wide">Priority</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentTickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-gray-400">{{ $ticket->id }}</td>
                                <td class="px-5 py-3 font-medium text-gray-900">
                                    {{ $ticket->title }}
                                </td>
                                <td class="px-5 py-3 text-gray-500">
                                    {{ $ticket->category->name ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-gray-500">
                                    {{ $ticket->assignee->name ?? '—' }}
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
            @endif
        </div>

    </div>
</x-app-layout>