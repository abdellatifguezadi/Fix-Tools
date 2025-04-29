@props(['categories'])

<div class="bg-white p-6 rounded-lg shadow-md mt-4">
    <h2 class="text-lg font-bold">Filter Tools</h2>
    <form action="{{ route('professionals.marketplace') }}" method="GET" class="flex flex-wrap gap-4 mt-2">
        <div class="flex-1">
            <input type="text" 
                name="search" 
                placeholder="Search for tools..." 
                value="{{ request('search') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
        </div>
        
        <select name="category" 
            class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <option value="">Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="price_range" 
            class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <option value="">Select price range</option>
            <option value="0-100" {{ request('price_range') == '0-100' ? 'selected' : '' }}>0 - 100 DH</option>
            <option value="101-500" {{ request('price_range') == '101-500' ? 'selected' : '' }}>101 - 500 DH</option>
            <option value="501-1000" {{ request('price_range') == '501-1000' ? 'selected' : '' }}>501 - 1000 DH</option>
            <option value="1001+" {{ request('price_range') == '1001+' ? 'selected' : '' }}>More than 1000 DH</option>
        </select>

        <select name="points_range" 
            class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <option value="">Select points range</option>
            <option value="0-50" {{ request('points_range') == '0-50' ? 'selected' : '' }}>0 - 50 points</option>
            <option value="51-100" {{ request('points_range') == '51-100' ? 'selected' : '' }}>51 - 100 points</option>
            <option value="101+" {{ request('points_range') == '101+' ? 'selected' : '' }}>More than 100 points</option>
        </select>

    </form>
</div> 