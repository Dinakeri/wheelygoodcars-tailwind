<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;

class PublicCarList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $allAvailableCars = Car::whereNull('sold_at')->get();

        $featuredCar = null;
        $excludedCarIds = [];

        if (empty($this->search) && $allAvailableCars->isNotEmpty()) {
            $featuredCar = $allAvailableCars->random();
            $excludedCarIds[] = $featuredCar->id;
        }

        $carsQuery = Car::whereNull('sold_at')
                        ->whereNotIn('id', $excludedCarIds);

        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $carsQuery->where(function ($query) use ($searchTerm) {
                $query->where('brand', 'like', $searchTerm)
                      ->orWhere('model', 'like', $searchTerm)
                      ->orWhere('license_plate', 'like', $searchTerm)
                      ->orWhere('color', 'like', $searchTerm);
            });

            $this->resetPage();
        }

        $paginatedCars = $carsQuery->paginate(12);

        return view('livewire.public-car-list', [
            'featuredCar' => $featuredCar,
            'cars' => $paginatedCars,
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}

