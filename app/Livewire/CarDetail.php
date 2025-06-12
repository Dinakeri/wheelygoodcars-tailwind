<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;

class CarDetail extends Component
{
    public Car $car;

    public function mount(Car $car)
    {
        $this->car = $car;

    }

    public function render()
    {
        return view('livewire.car-detail');
    }
}
