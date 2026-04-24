<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Business Unit Details</h1>
                <p class="text-sm text-gray-500">View business unit information.</p>
            </div>
            <a href="{{ route('business-units.edit', $businessUnit) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Edit
            </a>
        </div>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <div>
                <p class="text-sm text-gray-500">Code</p>
                <p class="text-base font-medium text-gray-800">{{ $businessUnit->code }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Name</p>
                <p class="text-base font-medium text-gray-800">{{ $businessUnit->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Description</p>
                <p class="text-base font-medium text-gray-800">{{ $businessUnit->description ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="text-base font-medium text-gray-800">{{ ucfirst($businessUnit->status) }}</p>
            </div>

            <div class="pt-4">
                <a href="{{ route('business-units.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>