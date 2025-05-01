<x-app-layout>
    <x-slot name="title">
        Reviews Management
    </x-slot>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 mt-16">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-semibold text-gray-900 mb-6">Reviews and Testimonials Management</h1>
            
            <!-- @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <div class="py-1">
                            <i class="fas fa-check-circle mr-2"></i>
                        </div>
                        <div>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif -->
            
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-star text-yellow-400 mr-2"></i> Testimonials List
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Professional</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reviews as $review)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                    src="{{ asset('images/perso.jpeg') }}" 
                                                    alt="{{ $review->client->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @if(!$review->client_id)
                                                        <span class="text-gray-500 italic">Deleted User</span>
                                                    @else
                                                        {{ $review->client->name }}
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    @if($review->client_id)
                                                        {{ $review->client->email }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                    src="{{ asset('images/perso.jpeg') }}" 
                                                    alt="{{ $review->professional->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @if(!$review->professional_id)
                                                        <span class="text-gray-500 italic">Deleted User</span>
                                                    @else
                                                        {{ $review->professional->name }}
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    @if($review->professional_id)
                                                        {{ $review->professional->email }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $review->serviceRequest->service->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $review->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="button" class="text-blue-600 hover:text-blue-900 mr-3" 
                                            onclick="openReviewModal('{{ $review->id }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <x-delete-confirmation-modal 
                                            :title="'Delete Review'"
                                            :message="'Are you sure you want to delete this review? This action cannot be undone.'">
                                            <i class="fas fa-trash"></i>
                                            <x-slot name="actions">
                                                <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Delete Review
                                                    </button>
                                                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Cancel
                                                    </button>
                                                </form>
                                            </x-slot>
                                        </x-delete-confirmation-modal>
                                    </td>
                                </tr>
                                
                                <div id="reviewModal-{{ $review->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
                                    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
                                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                            <h3 class="text-lg font-semibold text-gray-900">Review Details</h3>
                                            <button onclick="closeReviewModal('{{ $review->id }}')" class="text-gray-400 hover:text-gray-500">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="p-6">
                                            <div class="flex justify-between mb-6">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-500">Client</h4>
                                                    <p class="text-base font-medium">{{ $review->client->name }}</p>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-500">Professional</h4>
                                                    <p class="text-base font-medium">{{ $review->professional->name }}</p>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-500">Service</h4>
                                                    <p class="text-base font-medium">{{ $review->serviceRequest->service->name }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-6">
                                                <h4 class="text-sm font-medium text-gray-500 mb-2">Rating</h4>
                                                <div class="flex text-yellow-400 text-xl">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            
                                            <div class="mb-6">
                                                <h4 class="text-sm font-medium text-gray-500 mb-2">Comment</h4>
                                                <div class="bg-gray-50 p-4 rounded-lg">
                                                    <p class="text-gray-800">{{ $review->comment }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-between text-sm text-gray-500">
                                                <span>Created on: {{ $review->created_at->format('d/m/Y at H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                                            <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to delete this review?');"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                            <button onclick="closeReviewModal('{{ $review->id }}')" 
                                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-comment-slash text-4xl text-gray-300 mb-3"></i>
                                            <p>No reviews found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openReviewModal(reviewId) {
            document.getElementById('reviewModal-' + reviewId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeReviewModal(reviewId) {
            document.getElementById('reviewModal-' + reviewId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-app-layout> 