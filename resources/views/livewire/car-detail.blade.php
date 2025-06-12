<div> {{-- This is the new single root element --}}
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-4xl mx-auto relative">
            @if ($car->image)
                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gray-200 flex items-center justify-center text-gray-500 text-lg">
                    Geen Afbeelding Beschikbaar
                </div>
            @endif
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $car->brand }} {{ $car->model }}</h1>
                <p class="text-3xl font-extrabold text-indigo-700 mb-6">€{{ number_format($car->price, 0, ',', '.') }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-lg text-gray-800">
                    <div><span class="font-semibold">Kenteken:</span> {{ $car->license_plate }}</div>
                    <div><span class="font-semibold">Kilometerstand:</span> {{ number_format($car->mileage, 0, ',', '.') }} km</div>
                    <div><span class="font-semibold">Zitplaatsen:</span> {{ $car->seats ?? 'N/A' }}</div>
                    <div><span class="font-semibold">Deuren:</span> {{ $car->doors ?? 'N/A' }}</div>
                    <div><span class="font-semibold">Productiejaar:</span> {{ $car->production_year ?? 'N/A' }}</div>
                    <div><span class="font-semibold">Gewicht:</span> {{ $car->weight ? number_format($car->weight, 0, ',', '.') . ' kg' : 'N/A' }}</div>
                    <div><span class="font-semibold">Kleur:</span> {{ $car->color ?? 'N/A' }}</div>
                    <div><span class="font-semibold">Status:</span>
                        @if ($car->is_sold)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">Verkocht</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">Beschikbaar</span>
                        @endif
                    </div>
                    <div><span class="font-semibold">Aantal keer bekeken:</span> {{ number_format($car->views, 0, ',', '.') }}</div>
                    <div><span class="font-semibold">Geplaatst op:</span> {{ $car->created_at->format('d-m-Y H:i') }}</div>
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('public.cars.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Terug naar Overzicht
                    </a>
                </div>
            </div>

            <div id="reservationToast" class="fixed bottom-4 right-4 bg-yellow-500 text-white p-4 rounded-lg shadow-xl hidden z-50 animate-fade-in-up md:max-w-sm w-full transition-all duration-300 ease-out-quad">
                <div class="flex justify-between items-start">
                    <p class="font-bold text-lg mb-2">Deze auto wordt actief bekeken!</p>
                    <button type="button" onclick="document.getElementById('reservationToast').style.display='none';" class="text-white hover:text-gray-200 focus:outline-none -mt-2 -mr-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <p class="text-sm">Vandaag al <span class="font-bold">{{ number_format($car->views, 0, ',', '.') }}</span> keer bekeken!</p>
                <p class="text-sm mt-2">Interesse? Neem contact op om deze auto te reserveren of een vraag te stellen.</p>
                <div class="mt-4 text-center">
                    <a href="#" class="inline-block bg-white text-yellow-700 font-semibold py-2 px-4 rounded-md hover:bg-yellow-100 transition-colors duration-200 text-sm">Neem Contact Op</a>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            setTimeout(() => {
                const toast = document.getElementById('reservationToast');
                if (toast) {
                    toast.style.display = 'block';
                }
            }, 10000);
        });
    </script>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.5s ease-out forwards;
        }

        .ease-out-quad {
            transition-timing-function: cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
    </style>
</div>
