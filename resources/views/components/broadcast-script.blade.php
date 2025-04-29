<script>
    window.pusherKey = '{{ config('broadcasting.connections.pusher.key') }}';
    window.pusherCluster = '{{ config('broadcasting.connections.pusher.options.cluster') }}';
    window.userId = {{ auth()->id() }};
    
    console.log('Broadcasting configuration loaded');
</script>
@vite(['resources/js/app.js']) 