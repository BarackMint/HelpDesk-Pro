<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Banner --}}
            <div class="bg-gray-800 text-white sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold">
                    Welcome back, {{ auth()->user()->name }} 👋
                </h3>
                <p class="text-gray-400 text-sm mt-1">
                    Track your support tickets and stay updated on their progress.
                </p>
                <a href="{{ route('tickets.create') }}"
                    class="inline-block mt-4 px-5 py-2 bg-white text-gray-800 text-sm
                    font-medium rounded-md hover:bg-gray-100">
                    + Create New Ticket
                </a>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">My Tickets</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $stats['total_tickets'] }}
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

            {{-- Recent Tickets --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-800">My Recent Tickets</h3>
                    <a href="{{ route('tickets.index') }}"
                        class="text-sm text-blue-600 hover:underline">
                        View all →
                    </a>
                </div>

                @if($recentTickets->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-400 text-sm mb-3">
                            You have not submitted any tickets yet.
                        </p>
                        <a href="{{ route('tickets.create') }}"
                            class="px-4 py-2 bg-blue-600 text-white text-sm
                            rounded-md hover:bg-blue-500">
                            Create your first ticket
                        </a>
                    </div>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Assigned To</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Priority</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentTickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $ticket->id }}</td>
                                    <td class="px-4 py-3 font-medium">
                                        {{ $ticket->title }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $ticket->category->name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $ticket->assignee->name ?? 'Unassigned' }}
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