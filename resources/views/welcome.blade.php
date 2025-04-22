<x-app-layout>
    <x-slot name="title">
        Home
    </x-slot>

    <header class="bg-black text-white py-20 relative">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/service1.jpeg') }}" alt="Tools and Equipment" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Your Projects, <span class="text-yellow-400">Our Solutions</span>
            </h1>
            <p class="text-xl mb-8">
                Find qualified professionals for all your maintenance, installation and repair work
            </p>
            <button class="bg-yellow-400 text-black px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 inline-block">
                Find a Professional
            </button>
        </div>
    </header>

    <section class="py-16 relative">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Our Services</h2>

            <div class="absolute top-1/2 left-4 transform -translate-y-1/2 z-10">
                <button id="prevService" class="bg-black bg-opacity-50 hover:bg-yellow-400 text-white hover:text-black rounded-full p-3 focus:outline-none transition duration-300 shadow-lg">
                    <i class="fas fa-chevron-left text-xl"></i>
                </button>
            </div>
            
            <div class="absolute top-1/2 right-4 transform -translate-y-1/2 z-10">
                <button id="nextService" class="bg-black bg-opacity-50 hover:bg-yellow-400 text-white hover:text-black rounded-full p-3 focus:outline-none transition duration-300 shadow-lg">
                    <i class="fas fa-chevron-right text-xl"></i>
                </button>
            </div>
>
            <div class="overflow-hidden">
                <div id="serviceCarousel" class="flex flex-nowrap transition-transform duration-500 ease-in-out">

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service1.jpeg') }}" 
                                 alt="Plumbing" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">Plumbing</h3>
                                <p class="text-gray-600">Installation, repair and maintenance of your plumbing systems</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service2.jpeg') }}" 
                                 alt="Electricity" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">Electricity</h3>
                                <p class="text-gray-600">Electrical installations and repairs for your safety</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service3.jpeg') }}" 
                                 alt="Painting" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">Painting</h3>
                                <p class="text-gray-600">Interior and exterior painting work</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service4.jpeg') }}" 
                                 alt="Carpentry" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">Carpentry</h3>
                                <p class="text-gray-600">Custom woodworking and furniture assembly services</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service5.jpeg') }}" 
                                 alt="HVAC" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">HVAC</h3>
                                <p class="text-gray-600">Heating, ventilation, and air conditioning installation and repair</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service6.jpeg') }}" 
                                 alt="Gardening" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">Gardening</h3>
                                <p class="text-gray-600">Professional landscaping and garden maintenance services</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service7.jpeg') }}" 
                                 alt="Cleaning" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">Cleaning</h3>
                                <p class="text-gray-600">Professional cleaning and sanitization services for your home</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service8.jpeg') }}" 
                                 alt="Locksmith" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">Locksmith</h3>
                                <p class="text-gray-600">Lock installation, repair, and emergency lockout services</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 px-4 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                            <img src="{{ asset('images/service9.jpeg') }}" 
                                 alt="Moving" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">Moving</h3>
                                <p class="text-gray-600">Professional moving and heavy furniture transportation services</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-8">
                <div id="serviceIndicators" class="flex space-x-2">
                    <button class="w-3 h-3 rounded-full bg-yellow-400" data-slide="0"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300" data-slide="1"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300" data-slide="2"></button>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-black text-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-yellow-400">About Us</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h3 class="text-2xl font-bold text-yellow-400">Your Trusted Partner</h3>
                    <p class="text-gray-300">Fix and Tools connects homeowners with qualified professionals for all their maintenance and repair needs.</p>
                    <ul class="space-y-4">
                        <x-feature-item>Network of Verified Professionals</x-feature-item>
                        <x-feature-item>Guaranteed Quality Service</x-feature-item>
                        <x-feature-item>24/7 Customer Support</x-feature-item>
                    </ul>
                </div>
                <div class="relative h-96">
                    <img src="{{ asset('images/about.jpeg') }}" 
                        alt="Professional at work" 
                        class="w-full h-full object-cover rounded-lg shadow-xl">
                    <div class="absolute inset-0 bg-black opacity-40 rounded-lg"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Testimonials</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/perso.jpeg') }}" 
                             alt="Emily Davis" 
                             class="w-16 h-16 rounded-full">
                        <div class="ml-4">
                            <h3 class="font-bold">Emily Davis</h3>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The plumber from Fix and Tools arrived promptly and fixed our leaking pipe in less than an hour. Excellent service at a reasonable price!"</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/perso.jpeg') }}" 
                             alt="Robert Wilson" 
                             class="w-16 h-16 rounded-full">
                        <div class="ml-4">
                            <h3 class="font-bold">Robert Wilson</h3>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Had my entire living room repainted by a professional from Fix and Tools. They were meticulous with details and cleaned up perfectly after finishing."</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/perso.jpeg') }}" 
                             alt="Jennifer Lopez" 
                             class="w-16 h-16 rounded-full">
                        <div class="ml-4">
                            <h3 class="font-bold">Jennifer Lopez</h3>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"I've used Fix and Tools multiple times for various home projects. Their electrician did an amazing job installing new lighting throughout my house. Highly recommended!"</p>
                </div>
            </div>
        </div>
    </section>

    @guest
    <section class="bg-black py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to Start?</h2>
            <p class="text-yellow-400 text-xl mb-8">Join our community of professionals and satisfied clients</p>
            <div class="space-x-4">
                <button class="bg-yellow-400 text-black px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 inline-block">
                    I am a Client
                </button>
                <button class="border-2 border-yellow-400 text-yellow-400 px-8 py-3 rounded-lg font-bold hover:bg-yellow-400 hover:text-black inline-block">
                    I am a Professional
                </button>
            </div>
        </div>
    </section>
    @endguest

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            
            
            const carousel = document.getElementById('serviceCarousel');
            const prevButton = document.getElementById('prevService');
            const nextButton = document.getElementById('nextService');
            const indicators = document.querySelectorAll('#serviceIndicators button');
            
            console.log('Elements found:', {
                carousel: carousel,
                prevButton: prevButton,
                nextButton: nextButton,
                indicators: indicators.length
            });
            
            if (!carousel || !prevButton || !nextButton) {
                console.error('Required elements not found!');
                return;
            }
            
            let currentIndex = 0;
            const totalSlides = 3; 
            
            function updateCarousel() {
                console.log('Updating carousel to index:', currentIndex);
                const translateX = -(currentIndex * 100);
                carousel.style.transform = `translateX(${translateX}%)`;
                
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.remove('bg-gray-300');
                        indicator.classList.add('bg-yellow-400');
                    } else {
                        indicator.classList.remove('bg-yellow-400');
                        indicator.classList.add('bg-gray-300');
                    }
                });
            }
            
            prevButton.addEventListener('click', function(e) {
                console.log('Previous button clicked');
                e.preventDefault();
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = totalSlides - 1; 
                }
                updateCarousel();
            });
            
            nextButton.addEventListener('click', function(e) {
                console.log('Next button clicked');
                e.preventDefault();
                if (currentIndex < totalSlides - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateCarousel();
            });
            
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    console.log('Indicator clicked:', index);
                    currentIndex = index;
                    updateCarousel();
                });
            });
            

            updateCarousel();
            
            const autoplayInterval = setInterval(function() {
                console.log('Auto-advancing carousel');
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            }, 8000);
            
            carousel.addEventListener('mouseenter', function() {
                console.log('Mouse entered carousel, stopping autoplay');
                clearInterval(autoplayInterval);
            });
        });
    </script>
</x-app-layout>

@push('scripts')
<!-- Keep this empty to avoid conflicts -->
@endpush
