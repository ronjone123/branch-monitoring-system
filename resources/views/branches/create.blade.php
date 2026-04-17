<x-app-layout>
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Add Branch</h2>
            <p class="text-muted mb-0">Create a new branch record.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('branches.store') }}" method="POST">
                    @csrf
                    @include('branches._form', ['branch' => new \App\Models\Branch()])

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Branch</button>
                        <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>