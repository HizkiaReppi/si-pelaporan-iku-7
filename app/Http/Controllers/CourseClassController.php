<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CourseClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.kelas-mata-kuliah.index');
    }
}
