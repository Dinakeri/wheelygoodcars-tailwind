<div>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Beschikbare Auto's</h1>

        <div class="mb-8 flex justify-center">
            <input
                type="text"
                placeholder="Zoek op merk, model, kenteken of kleur..."
                class="w-full md:w-2/3 lg:w-1/2 p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                wire:model.live="search"
            >
        </div>

        @if ($featuredCar && empty($search))
            <div class="mb-10 p-6 bg-blue-100 rounded-lg shadow-xl border-2 border-blue-300 transform transition-all duration-300 hover:scale-101 animate-fade-in">
                <h2 class="text-2xl font-bold text-blue-800 mb-4 text-center">Uitgelichte Auto!</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div class="relative overflow-hidden rounded-lg shadow-lg">
                        @if ($featuredCar->image)
                            <img src="{{ asset('storage/' . $featuredCar->image) }}" alt="{{ $featuredCar->brand }} {{ $featuredCar->model }}" class="w-full h-80 object-cover rounded-lg">
                        @else
                            <div class="w-full h-80 bg-gray-200 flex items-center justify-center text-gray-500 text-lg rounded-lg">
                                Geen Afbeelding Beschikbaar
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-3xl font-semibold text-gray-900 mb-2">{{ $featuredCar->brand }} {{ $featuredCar->model }}</h3>
                        <p class="text-4xl font-extrabold text-indigo-700 mb-4">€{{ number_format($featuredCar->price, 0, ',', '.') }}</p>
                        <div class="text-gray-700 space-y-2">
                            <p><span class="font-medium">Kenteken:</span> {{ $featuredCar->license_plate }}</p>
                            <p><span class="font-medium">Kilometerstand:</span> {{ number_format($featuredCar->mileage, 0, ',', '.') }} km</p>
                            <p><span class="font-medium">Productiejaar:</span> {{ $featuredCar->production_year }}</p>
                            <p><span class="font-medium">Kleur:</span> {{ $featuredCar->color ?? 'Onbekend' }}</p>
                            <p><span class="font-medium">Views:</span> {{ number_format($featuredCar->views, 0, ',', '.') }}</p>
                        </div>
                        <div class="mt-6 text-center md:text-left">
                            <a href="{{ route('public.cars.show', $featuredCar) }}" class="inline-block bg-blue-600 text-white font-semibold py-3 px-6 rounded-md hover:bg-blue-700 transition-colors duration-200 text-lg shadow-md">Bekijk Volledige Details</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($cars->isEmpty() && !$featuredCar)
            <p class="text-center text-gray-600 text-lg">Momenteel zijn er geen auto's beschikbaar die voldoen aan de zoekcriteria.</p>
        @else
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Overige Aanbiedingen</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($cars as $car)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-200 hover:scale-105">
                        @if ($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                                Geen Afbeelding Beschikbaar
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $car->brand }} {{ $car->model }}</h3>
                            <p class="text-2xl font-bold text-indigo-600 mb-3">€{{ number_format($car->price, 0, ',', '.') }}</p>
                            <div class="text-gray-700 text-sm space-y-1">
                                <p><span class="font-medium">Kenteken:</span> {{ $car->license_plate }}</p>
                                <p><span class="font-medium">Kilometerstand:</span> {{ number_format($car->mileage, 0, ',', '.') }} km</p>
                                <p><span class="font-medium">Productiejaar:</span> {{ $car->production_year }}</p>
                                <p><span class="font-medium">Kleur:</span> {{ $car->color ?? 'Onbekend' }}</p>
                                <p><span class="font-medium">Zitplaatsen:</span> {{ $car->seats ?? 'Onbekend' }}</p>
                                <p><span class="font-medium">Deuren:</span> {{ $car->doors ?? 'Onbekend' }}</p>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('public.cars.show', $car) }}" class="inline-block bg-indigo-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-600 transition-colors duration-200">Bekijk Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $cars->links() }}
            </div>
        @endif
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }
    </style>
</div>
