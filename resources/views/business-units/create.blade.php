<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Add Business Unit</h1>
            <p class="text-sm text-gray-500">Create a new business unit record.</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('business-units.store') }}" method="POST">
                @csrf
                @include('business-units._form', ['businessUnit' => new \App\Models\BusinessUnit()])

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save
                    </button>
                    <a href="{{ route('business-units.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>