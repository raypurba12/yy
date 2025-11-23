<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cold Storage Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Cold Storage Unit Details: {{ $coldStorage->name }}</h3>
                        <div>
                            <a href="{{ route('cold-storage.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Back to List
                            </a>
                            <a href="{{ route('cold-storage.edit', $coldStorage) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p><span class="font-semibold">ID:</span> {{ $coldStorage->id }}</p>
                            <p><span class="font-semibold">Name:</span> {{ $coldStorage->name }}</p>
                            <p><span class="font-semibold">Location:</span> {{ $coldStorage->location }}</p>
                            <p><span class="font-semibold">Current Temperature:</span> {{ $coldStorage->current_temperature }}°C</p>
                            <p><span class="font-semibold">Target Temperature:</span> {{ $coldStorage->target_temperature }}°C</p>
                            <p><span class="font-semibold">Status:</span> 
                                @if($coldStorage->status == 'active')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @elseif($coldStorage->status == 'maintenance')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Maintenance
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Offline
                                    </span>
                                @endif
                            </p>
                            <p><span class="font-semibold">Created At:</span> {{ $coldStorage->created_at->format('M d, Y H:i') }}</p>
                            <p><span class="font-semibold">Updated At:</span> {{ $coldStorage->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p><span class="font-semibold">Description:</span></p>
                            <p class="mt-2">{{ $coldStorage->description ?: 'No description provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>