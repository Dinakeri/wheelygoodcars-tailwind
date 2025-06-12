<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;

class PublicCarList extends Component
{
    use WithPagination;

    public function render()
    {

        $allAvailableCars = Car::whereNull('sold_at')->get();

        $featuredCar = null;
        $excludedCarIds = [];

        if ($allAvailableCars->isNotEmpty()) {
            $featuredCar = $allAvailableCars->random();
            $excludedCarIds[] = $featuredCar->id;
        }

        $carsQuery = Car::whereNull('sold_at')
                        ->whereNotIn('id', $excludedCarIds);


        $paginatedCars = $carsQuery->paginate(12);

        return view('livewire.public-car-list', [
            'featuredCar' => $featuredCar,
            'cars' => $paginatedCars,
        ]);
    }
}
