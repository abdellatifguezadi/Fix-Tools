@props(['type' => 'success'])

@if(session($type))
    <div id="toast-container" class="fixed top-4 right-4 z-50">
        <div id="toast-{{ $type }}" class="transform transition-all duration-500 translate-x-0 opacity-100">
            <div class="bg-{{ $type === 'success' ? 'green' : 'red' }}-100 border border-{{ $type === 'success' ? 'green' : 'red' }}-400 text-{{ $type === 'success' ? 'green' : 'red' }}-700 px-6 py-4 rounded-lg relative shadow-lg min-w-[300px]" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($type === 'success')
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        @else
                            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session($type) }}</p>
                        
                        @if($type === 'error' && $errors && $errors->any())
                            <ul class="list-disc list-inside mt-2 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <button onclick="closeToast('toast-{{ $type }}')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.remove();
            }
        }

        setTimeout(() => {
            const toast = document.getElementById('toast-{{ $type }}');
            if (toast) {
                toast.remove();
            }
        }, 5000);
    </script>
@elseif($type === 'error' && $errors && $errors->any() && !session('success'))
    <div id="toast-container" class="fixed top-4 right-4 z-50">
        <div id="toast-error" class="transform transition-all duration-500 translate-x-0 opacity-100">
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg relative shadow-lg min-w-[300px]" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">Veuillez corriger les erreurs suivantes:</p>
                        <ul class="list-disc list-inside mt-2 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button onclick="closeToast('toast-error')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.remove();
            }
        }

        setTimeout(() => {
            const toast = document.getElementById('toast-error');
            if (toast) {
                toast.remove();
            }
        }, 8000);
    </script>
@endif 