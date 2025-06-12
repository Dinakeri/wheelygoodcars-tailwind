<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use Carbon\Carbon;

class CarDetail extends Component
{
    public Car $car;

    public function mount(Car $car)
    {
        $this->car = $car;

        $this->car->increment('views');
    }

    public function render()
    {
        return view('livewire.car-detail');
    }
}
