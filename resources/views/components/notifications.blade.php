@props(['type' => 'success'])

@if(session($type))
    <div id="{{ $type }}-notification" class="bg-{{ $type === 'success' ? 'green' : 'red' }}-100 border border-{{ $type === 'success' ? 'green' : 'red' }}-400 text-{{ $type === 'success' ? 'green' : 'red' }}-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session($type) }}</span>
        <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('{{ $type }}-notification');
            if (notification) {
                setTimeout(() => {
                    notification.style.transition = 'opacity 0.5s ease-in-out';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 500);
                }, 5000);
            }
        });
    </script>
@endif 