<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Agent Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Assigned Tickets</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $stats['assigned_tickets'] }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Open</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">
                        {{ $stats['open_tickets'] }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">In Progress</p>
                    <p class="text-3xl font-bold text-yellow-500 mt-1">
                        {{ $stats['in_progress'] }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Resolved</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">
                        {{ $stats['resolved_tickets'] }}
                    </p>
                </div>

            </div>

            {{-- Quick Actions --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('tickets.index') }}"
                        class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">
                        View My Tickets
                    </a>
                    <a href="{{ route('tickets.index') }}?status=open"
                        class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-500">
                        Open Tickets
                    </a>
                    <a href="{{ route('tickets.index') }}?status=in_progress"
                        class="px-4 py-2 bg-yellow-500 text-white text-sm rounded-md hover:bg-yellow-400">
                        In Progress
                    </a>
                </div>
            </div>

            {{-- Recent Assigned Tickets --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-800">Recently Assigned Tickets</h3>
                    <a href="{{ route('tickets.index') }}"
                        class="text-sm text-blue-600 hover:underline">
                        View all →
                    </a>
                </div>

                @if($recentTickets->isEmpty())
                    <p class="text-gray-400 text-sm">No tickets assigned to you yet.</p>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Created By</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Priority</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentTickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $ticket->id }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $ticket->title }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $ticket->creator->name }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $ticket->category->name ?? '—' }}
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
                                        <a href="{{ route('tickets.show', $ticket) }}"
                                            class="text-blue-600 hover:underline">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>