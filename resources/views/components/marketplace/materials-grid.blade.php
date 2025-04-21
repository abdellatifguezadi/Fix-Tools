@if($materials->isEmpty())
    <div class="text-center py-8">
        <i class="fas fa-tools text-gray-400 text-4xl mb-4"></i>
        <p class="text-gray-600">No tools match your search criteria.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($materials as $material)
            <x-marketplace.material-card :material="$material" />
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $materials->links() }}
    </div>
@endif 