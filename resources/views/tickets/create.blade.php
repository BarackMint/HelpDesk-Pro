<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-base font-semibold text-gray-900">Create Ticket</h1>
            <p class="text-sm text-gray-400 mt-0.5">Submit a new support request</p>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <form method="POST" action="{{ route('tickets.store') }}">
                @csrf

                <div class="space-y-5">

                    {{-- Title --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-400
                            uppercase tracking-wide mb-1.5">
                            Title <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            placeholder="Brief summary of the issue"
                            class="w-full border-gray-200 rounded-md text-sm
                            focus:ring-gray-900 focus:border-gray-900
                            @error('title') border-red-300 @enderror"/>
                        @error('title')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-400
                            uppercase tracking-wide mb-1.5">
                            Description <span class="text-red-400">*</span>
                        </label>
                        <textarea name="description" rows="5"
                            placeholder="Describe the issue in detail..."
                            class="w-full border-gray-200 rounded-md text-sm
                            focus:ring-gray-900 focus:border-gray-900
                            @error('description') border-red-300 @enderror"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Priority & Category --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400
                                uppercase tracking-wide mb-1.5">
                                Priority <span class="text-red-400">*</span>
                            </label>
                            <select name="priority"
                                class="w-full border-gray-200 rounded-md text-sm
                                focus:ring-gray-900 focus:border-gray-900
                                @error('priority') border-red-300 @enderror">
                                <option value="">Select Priority</option>
                                @foreach(['low', 'medium', 'high', 'critical'] as $priority)
                                    <option value="{{ $priority }}"
                                        {{ old('priority') === $priority ? 'selected' : '' }}>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-400
                                uppercase tracking-wide mb-1.5">Category</label>
                            <select name="category_id"
                                class="w-full border-gray-200 rounded-md text-sm
                                focus:ring-gray-900 focus:border-gray-900
                                @error('category_id') border-red-300 @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id
                                            ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-100">
                    <button type="submit"
                        class="px-4 py-2 bg-gray-900 text-white text-sm font-medium
                        rounded-md hover:bg-gray-700 transition-colors">
                        Submit Ticket
                    </button>
                    <a href="{{ route('tickets.index') }}"
                        class="px-4 py-2 bg-white text-gray-600 text-sm font-medium
                        rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>