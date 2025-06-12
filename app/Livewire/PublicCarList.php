<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car; // Ensure the Car model is imported
use Livewire\WithPagination; // Trait for pagination

class PublicCarList extends Component
{
    use WithPagination;

    public function render()
    {
        // Fetch all cars that are not sold.
        // We'll add search, filtering, and pagination later for F7, F8, F9.
        $cars = Car::whereNull('sold_at')->paginate(12); // paginate for F8

        return view('livewire.public-car-list', [
            'cars' => $cars,
        ]);
    }
}
