<?php

namespace App\View\Components;

use App\Models\Course;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public function render()
    {
        if(auth()->user()->role !== 'admin-prodi') {
            return view('components.sidebar');
        } else {
            $courses = Course::where('department_id', auth()->user()->department_id)->get();
            return view('components.sidebar', compact('courses'));
        }
    }
}
