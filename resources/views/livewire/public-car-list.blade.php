<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Beschikbare Auto's</h1>

    @if ($cars->isEmpty())
        <p class="text-center text-gray-600 text-lg">Momenteel zijn er geen auto's beschikbaar.</p>
    @else
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
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $car->brand }} {{ $car->model }}</h2>
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
