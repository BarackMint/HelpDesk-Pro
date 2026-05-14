<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Ticket #{{ $ticket->id }}
            </h2>
            <a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-gray-500 hover:underline">
                ← Back to Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                    @csrf
                    @method('PATCH')

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $ticket->title) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm @error('title') border-red-500 @enderror"
                        />
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="description"
                            rows="5"
                            class="w-full border-gray-300 rounded-md shadow-sm @error('description') border-red-500 @enderror"
                        >{{ old('description', $ticket->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Priority & Category --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                        {{-- Priority --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Priority <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="priority"
                                class="w-full border-gray-300 rounded-md shadow-sm @error('priority') border-red-500 @enderror"
                            >
                                @foreach(['low', 'medium', 'high', 'critical'] as $priority)
                                    <option value="{{ $priority }}"
                                        {{ old('priority', $ticket->priority) === $priority ? 'selected' : '' }}>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select
                                name="category_id"
                                class="w-full border-gray-300 rounded-md shadow-sm @error('category_id') border-red-500 @enderror"
                            >
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Status & Assignment — Agent & Admin Only --}}
                    @if(auth()->user()->isAgent() || auth()->user()->isAdmin())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select
                                    name="status"
                                    class="w-full border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                >
                                    @foreach(['open', 'in_progress', 'resolved', 'closed'] as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status', $ticket->status) === $status ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Assignment — Admin Only --}}
                            @if(auth()->user()->isAdmin())
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Assigned To
                                    </label>
                                    <select
                                        name="assigned_to"
                                        class="w-full border-gray-300 rounded-md shadow-sm @error('assigned_to') border-red-500 @enderror"
                                    >
                                        <option value="">Unassigned</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}"
                                                {{ old('assigned_to', $ticket->assigned_to) == $agent->id ? 'selected' : '' }}>
                                                {{ $agent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center gap-4 mt-6">
                        <button
                            type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500"
                        >
                            Update Ticket
                        </button>
                        
                            href="{{ route('tickets.show', $ticket) }}"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                        >
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>