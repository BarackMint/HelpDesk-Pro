<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category Management
            </h2>
            <a href="{{ route('admin.categories.create') }}"
                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-500">
                + New Category
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Categories Table --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($categories->isEmpty())
                        <p class="text-gray-500">No categories found.</p>
                    @else
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Tickets</th>
                                    <th class="px-4 py-3">Created</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($categories as $category)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $category->id }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700
                                                rounded-full text-xs font-semibold">
                                                {{ $category->tickets_count }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500">
                                            {{ $category->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                    class="text-blue-600 hover:underline">
                                                    Edit
                                                </a>

                                                {{-- Delete --}}
                                                @if($category->tickets_count === 0)
                                                    <form method="POST"
                                                        action="{{ route('admin.categories.destroy', $category) }}"
                                                        onsubmit="return confirm('Delete this category?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:underline">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-300 cursor-not-allowed"
                                                        title="Cannot delete — has tickets assigned">
                                                        Delete
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $categories->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>