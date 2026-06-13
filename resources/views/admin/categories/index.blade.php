<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base font-semibold text-gray-900">Categories</h1>
                <p class="text-sm text-gray-400 mt-0.5">Manage ticket categories</p>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="px-4 py-2 bg-gray-900 text-white text-sm font-medium
                rounded-md hover:bg-gray-700 transition-colors">
                + New Category
            </a>
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

        {{-- Categories Table --}}
        <div class="bg-white rounded-lg border border-gray-100">
            @if($categories->isEmpty())
                <div class="px-5 py-12 text-center">
                    <p class="text-sm text-gray-400">No categories yet.</p>
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
                                text-gray-400 uppercase tracking-wide">Tickets</th>
                            <th class="px-5 py-3 text-left text-xs font-medium
                                text-gray-400 uppercase tracking-wide">Created</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-gray-400">{{ $category->id }}</td>
                                <td class="px-5 py-3 font-medium text-gray-900">
                                    {{ $category->name }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5
                                        rounded text-xs font-medium bg-gray-100 text-gray-500">
                                        {{ $category->tickets_count }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-400">
                                    {{ $category->created_at->diffForHumans() }}
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="text-xs text-gray-400 hover:text-gray-700
                                            transition-colors">
                                            Edit
                                        </a>
                                        @if($category->tickets_count === 0)
                                            <form method="POST"
                                                action="{{ route('admin.categories.destroy',
                                                    $category) }}"
                                                onsubmit="return confirm(
                                                    'Delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-xs text-red-400
                                                    hover:text-red-600 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-300
                                                cursor-not-allowed"
                                                title="Has tickets assigned">
                                                Delete
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $categories->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>