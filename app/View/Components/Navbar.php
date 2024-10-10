<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;

class Navbar extends Component
{
    public $registrations;
    public int $registrationsCount;

    public function __construct()
    {
        $user = auth()->user();

        if ($user->role !== 'admin-prodi') {
            $this->registrations = User::with(['prodi'])
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
        }

        $this->registrationsCount = $this->registrations->count();
    }

    public function render()
    {
        return view('components.navbar', [
            'registrations' => $this->registrations,
            'registrationsCount' => $this->registrationsCount
        ]);
    }
}
