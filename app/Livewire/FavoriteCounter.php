<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoriteCounter extends Component
{
    protected $listeners = ['favoriteUpdated' => 'render'];

    public function render()
    {
        $count = 0;

        if (Auth::check()) {
            $count = Auth::user()->favorites()->count();
        }

        return view('livewire.favorite-counter', [
            'count' => $count,
        ]);
    }
}
