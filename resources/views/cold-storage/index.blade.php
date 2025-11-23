<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cold Storage Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-x-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Cold Storage Units</h3>
                        <a href="{{ route('cold-storage.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Unit
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Wrapper container specifically for horizontal scroll -->
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm mb-4">
                        <div class="block w-full overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Current Temp</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Target Temp</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($coldStorages as $coldStorage)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $coldStorage->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $coldStorage->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $coldStorage->location }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $coldStorage->current_temperature }}°C</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $coldStorage->target_temperature }}°C</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($coldStorage->status == 'active')
                                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full dark:bg-green-900/30 dark:text-green-300">
                                                    Active
                                                </span>
                                            @elseif($coldStorage->status == 'maintenance')
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full dark:bg-yellow-900/30 dark:text-yellow-300">
                                                    Maintenance
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full dark:bg-red-900/30 dark:text-red-300">
                                                    Offline
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('cold-storage.show', $coldStorage) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</a>
                                                <a href="{{ route('cold-storage.edit', $coldStorage) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                                <form action="{{ route('cold-storage.destroy', $coldStorage) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this cold storage unit?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $coldStorages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Scrollbar */
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #06b6d4, #3b82f6);
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to right, #0891b2, #2563eb);
        }

        /* Dark mode scrollbar */
        .dark .overflow-x-auto {
            scrollbar-color: #4b5563 #1f2937;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #0891b2, #2563eb);
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to right, #06b6d4, #3b82f6);
        }
    </style>
</x-app-layout>