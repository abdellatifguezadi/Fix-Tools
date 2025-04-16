@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service Tracking') }}
        </h2>
    </x-slot>

    <div class="min-h-screen pb-32">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-xl font-bold">Service Tracking</h1>
                            <div class="bg-yellow-100 px-4 py-2 rounded-lg">
                                <span class="text-yellow-800">Points accumulés : </span>
                                <span class="font-bold text-yellow-800">{{ $totalPoints ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Summary Section -->
                        <div class="bg-white p-6 rounded-lg shadow-md mt-4">
                            <h2 class="text-lg font-bold mb-4">Résumé des Points</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                    <h3 class="font-semibold text-yellow-800">Services Complétés</h3>
                                    <p class="text-2xl font-bold text-yellow-600">{{ $completedServicesCount ?? 0 }}</p>
                                    <p class="text-sm text-gray-600">Ce mois</p>
                                </div>
                                
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                    <h3 class="font-semibold text-yellow-800">Points Accumulés</h3>
                                    <p class="text-2xl font-bold text-yellow-600">{{ $totalPoints ?? 0 }}</p>
                                    <p class="text-sm text-gray-600">Ce mois</p>
                                </div>
                                
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                    <h3 class="font-semibold text-yellow-800">Niveau Fidélité</h3>
                                    @php
                                        $level = 'Bronze';
                                        $allTimePoints = \App\Models\LoyaltyPoint::where('professional_id', Auth::id())->sum('points_earned');
                                        if ($allTimePoints >= 100) $level = 'Argent';
                                        if ($allTimePoints >= 250) $level = 'Or';
                                        if ($allTimePoints >= 500) $level = 'Platine';
                                        if ($allTimePoints >= 1000) $level = 'Diamant';
                                    @endphp
                                    <p class="text-2xl font-bold 
                                        @if($level == 'Bronze') text-yellow-700
                                        @elseif($level == 'Argent') text-gray-500
                                        @elseif($level == 'Or') text-yellow-500
                                        @elseif($level == 'Platine') text-blue-500
                                        @else text-purple-500 @endif">
                                        {{ $level }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $allTimePoints }} points totaux</p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <h3 class="font-semibold mb-2">Comment gagner des points</h3>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li><i class="fas fa-check-circle text-green-500 mr-1"></i> 5 points pour chaque service complété</li>
                                    <li><i class="fas fa-star text-yellow-500 mr-1"></i> 1 point par étoile dans les avis clients</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Services Complétés -->
                        <h2 class="text-xl font-bold mt-8">Services Complétés</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                            @forelse($completedServices ?? [] as $serviceRequest)
                            <div class="bg-white p-4 rounded-lg shadow-lg border-t-4 border-yellow-400 transition-transform transform hover:scale-105 cursor-pointer">
                                @if($serviceRequest->service && $serviceRequest->service->image_path)
                                    <img src="/storage/{{ $serviceRequest->service->image_path }}" 
                                         alt="{{ $serviceRequest->service->name }}" 
                                         class="w-full h-32 object-cover rounded-md mb-2">
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-md mb-2 flex items-center justify-center">
                                        <i class="fas fa-tools text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                                <h3 class="font-bold">{{ $serviceRequest->service ? $serviceRequest->service->name : 'Service inconnu' }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $serviceRequest->service ? Str::limit($serviceRequest->service->description, 100) : 'Aucune description disponible' }}</p>
                                
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-sm text-gray-500">{{ $serviceRequest->completion_date ? $serviceRequest->completion_date->format('d/m/Y') : 'Date inconnue' }}</p>
                                    <p class="text-sm text-gray-500">{{ $serviceRequest->final_price ? number_format($serviceRequest->final_price, 2) . ' €' : 'Prix non défini' }}</p>
                                </div>
                                
                                <!-- Points breakdown -->
                                <div class="bg-yellow-50 p-2 rounded-lg border border-yellow-100 mt-2">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-medium text-yellow-800">Points gagnés:</span>
                                        @php
                                            $completionPoints = 5;
                                            $reviewPoints = $serviceRequest->review ? $serviceRequest->review->rating : 0;
                                            $totalServicePoints = $serviceRequest->loyaltyPoints ? $serviceRequest->loyaltyPoints->points_earned : ($completionPoints + $reviewPoints);
                                        @endphp
                                        <span class="font-bold text-yellow-700">{{ $totalServicePoints }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between text-xs text-gray-600 mt-1">
                                        <span>Service: {{ $completionPoints }}</span>
                                        <span>Avis: {{ $reviewPoints }}</span>
                                    </div>
                                </div>
                                
                                <!-- Review -->
                                @if($serviceRequest->review)
                                    <div class="mt-3 p-2 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center mb-1">
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $serviceRequest->review->rating)
                                                        <i class="fas fa-star text-xs"></i>
                                                    @else
                                                        <i class="far fa-star text-xs"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500 ml-2">Par {{ $serviceRequest->review->client->name }}</span>
                                        </div>
                                        <p class="text-gray-600 text-sm italic">"{{ Str::limit($serviceRequest->review->comment, 50) }}"</p>
                                    </div>
                                @endif
                            </div>
                            @empty
                            <div class="col-span-3">
                                <div class="bg-gray-50 rounded-lg p-6 text-center">
                                    <p class="text-gray-600">Aucun service complété pour le moment.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 