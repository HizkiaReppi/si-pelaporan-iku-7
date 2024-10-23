<?php

namespace App\View\Components;

use App\Helpers\PeriodHelper;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Period;

class Navbar extends Component
{
    public $registrations = null;
    public int $registrationsCount = 0;


    public function __construct()
    {
        $user = auth()->user();

        if ($user->role !== 'admin-prodi') {
            $this->registrations = User::with(['prodi'])
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

            $this->registrationsCount = $this->registrations->count();
        }
    }

    public function render()
    {
        $periods = Period::all();

        $currentPeriodId = null;
        if(PeriodHelper::getCurrentPeriod() == null) {
            PeriodHelper::setCurrentPeriod($periods->first()->id);
            $currentPeriodId = $periods->first()->id;
        } else {
            $currentPeriodId = PeriodHelper::getCurrentPeriod();
        }

        return view('components.navbar', [
            'registrations' => $this->registrations,
            'registrationsCount' => $this->registrationsCount,
            'periods' => $periods,
            'currentPeriodId' => $currentPeriodId
        ]);
    }
}
