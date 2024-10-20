<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\IKU7;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|RedirectResponse
    {
        if (!Gate::allows('admin') && !Gate::allows('super-admin')) {
            abort(403);
        }

        $totalDepartmentsWithAccounts = User::has('prodi')->count();
        $totalCourses = Course::count();
        $totalCoursesReported = $this->getTotalCoursesReported();
        $totalCoursesNotReported = $this->getTotalCoursesNotReported();
        return view('dashboard.index', compact('totalCourses', 'totalDepartmentsWithAccounts', 'totalCoursesReported', 'totalCoursesNotReported'));
    }

    private function getTotalCoursesReported()
    {
        return IKU7::whereNotNull('score_case_method')->whereNotNull('score_project_based')->whereNotNull('score_cognitive_task')->whereNotNull('score_cognitive_quiz')->whereNotNull('score_cognitive_uts')->whereNotNull('score_cognitive_uas')->whereNotNull('description_case_method')->whereNotNull('description_project_based')->whereNotNull('description_cognitive_task')->whereNotNull('description_cognitive_quiz')->whereNotNull('description_cognitive_uts')->whereNotNull('description_cognitive_uas')->whereNotNull('file_rps')->count();
    }

    private function getTotalCoursesNotReported()
    {
        return IKU7::whereNull('score_case_method')->orWhereNull('score_project_based')->orWhereNull('score_cognitive_task')->orWhereNull('score_cognitive_quiz')->orWhereNull('score_cognitive_uts')->orWhereNull('score_cognitive_uas')->orWhereNull('description_case_method')->orWhereNull('description_project_based')->orWhereNull('description_cognitive_task')->orWhereNull('description_cognitive_quiz')->orWhereNull('description_cognitive_uts')->orWhereNull('description_cognitive_uas')->orWhereNull('file_rps')->count();
    }
}
