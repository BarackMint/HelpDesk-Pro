<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket #{{ $ticket->id }} — {{ $ticket->title }}
            </h2>
            <a href="{{ route('tickets.index') }}" class="text-sm text-gray-500 hover:underline">
                ← Back to Tickets
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Ticket Details --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex gap-2">

                        {{-- Priority Badge --}}
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $ticket->priority === 'critical' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $ticket->priority === 'high' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $ticket->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $ticket->priority === 'low' ? 'bg-green-100 text-green-700' : '' }}
                        ">
                            {{ ucfirst($ticket->priority) }}
                        </span>

                        {{-- Status Badge --}}
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $ticket->status === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $ticket->status === 'resolved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-700' : '' }}
                        ">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>

                    </div>

                    {{-- Edit Button --}}
                    @if(auth()->user()->isAdmin() || auth()->user()->isAgent() || $ticket->created_by === auth()->id())
                        <a href="{{ route('tickets.edit', $ticket) }}"
                            class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">
                            Edit Ticket
                        </a>
                    @endif
                </div>

                {{-- Meta --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 text-sm text-gray-600">
                    <div>
                        <p class="font-medium text-gray-800">Category</p>
                        <p>{{ $ticket->category->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Created By</p>
                        <p>{{ $ticket->creator->name }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Assigned To</p>
                        <p>{{ $ticket->assignee->name ?? 'Unassigned' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Created</p>
                        <p>{{ $ticket->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Description --}}
                <div class="border-t pt-4">
                    <p class="text-sm font-medium text-gray-800 mb-2">Description</p>
                    <p class="text-gray-700 whitespace-pre-line">{{ $ticket->description }}</p>
                </div>
            </div>

            {{-- Assignment — Admin Only --}}
            @if(auth()->user()->isAdmin())
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4">Assign Ticket</h3>
                    <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center gap-4">
                            <select name="assigned_to" class="border-gray-300 rounded-md shadow-sm">
                                <option value="">Unassigned</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}"
                                        {{ $ticket->assigned_to === $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 text-sm">
                                Assign
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Replies Thread --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">
                    Replies ({{ $ticket->replies->count() }})
                </h3>

                @forelse($ticket->replies as $reply)
                    <div class="flex gap-4 pb-4 mb-4 border-b last:border-0 last:pb-0 last:mb-0">

                        {{-- Avatar --}}
                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center
                            text-xs font-bold text-gray-600 shrink-0">
                            {{ strtoupper(substr($reply->author->name, 0, 1)) }}
                        </div>

                        {{-- Content --}}
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-800">
                                        {{ $reply->author->name }}
                                    </span>
                                    {{-- Role Badge --}}
                                    <span class="px-2 py-0.5 rounded-full text-xs
                                        {{ $reply->author->isAdmin() ? 'bg-red-100 text-red-600' : '' }}
                                        {{ $reply->author->isAgent() ? 'bg-blue-100 text-blue-600' : '' }}
                                        {{ $reply->author->isEmployee() ? 'bg-gray-100 text-gray-600' : '' }}
                                    ">
                                        {{ ucfirst($reply->author->role) }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-400">
                                    {{ $reply->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700 text-sm whitespace-pre-line">{{ $reply->body }}</p>
                        </div>

                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No replies yet. Be the first to respond.</p>
                @endforelse

                {{-- Reply Form --}}
                @if(!$ticket->isClosed())
                    <div class="mt-6 border-t pt-6">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3">Post a Reply</h4>
                        <form method="POST" action="{{ route('tickets.replies.store', $ticket) }}">
                            @csrf

                            {{-- Reply Body --}}
                            <div class="mb-4">
                                <textarea
                                    name="body"
                                    rows="4"
                                    class="w-full border-gray-300 rounded-md shadow-sm
                                        @error('body') border-red-500 @enderror"
                                    placeholder="Write your reply..."
                                >{{ old('body') }}</textarea>
                                @error('body')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status Update — Agent & Admin Only --}}
                            @if(auth()->user()->isAgent() || auth()->user()->isAdmin())
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Update Status
                                        <span class="text-gray-400 font-normal">(optional)</span>
                                    </label>
                                    <select name="status"
                                        class="border-gray-300 rounded-md shadow-sm
                                            @error('status') border-red-500 @enderror">
                                        <option value="">— No Change —</option>
                                        @foreach(['open', 'in_progress', 'resolved', 'closed'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status') === $status ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 text-sm">
                                Post Reply
                            </button>

                        </form>
                    </div>
                @else
                    <div class="mt-6 border-t pt-4">
                        <p class="text-sm text-gray-400">
                            This ticket is closed. No further replies can be added.
                        </p>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>