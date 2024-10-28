<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\IKU7;
use App\Models\Period;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (!Gate::allows('admin') && !Gate::allows('super-admin')) {
            abort(403);
        }

        $totalDepartmentsWithAccounts = User::has('prodi')->count();
        $totalCourses = Course::count();
        $totalCoursesReported = $this->getTotalCoursesReported();
        $totalCoursesNotReported = $this->getTotalCoursesNotReported();

        $submissionFacultiesData = IKU7::with('user.prodi.fakultas')
            ->get()
            ->groupBy('user.prodi.fakultas.name')
            ->map(function ($items) {
                return $items->count();
            });

        $verificationStatus = IKU7::select('status_verifikasi')->selectRaw('COUNT(*) as total')->groupBy('status_verifikasi')->get();

        $scoreTrends = Period::with([
            'pelaporanIku' => function ($query) {
                $query->selectRaw('period_id, AVG(score_case_method + score_project_based + score_cognitive_task + score_cognitive_quiz + score_cognitive_uts + score_cognitive_uas) as avg_score')->groupBy('period_id');
            },
        ])->get();

        $faculties = Faculty::all();

        return view('dashboard.index', compact('totalCourses', 'totalDepartmentsWithAccounts', 'totalCoursesReported', 'totalCoursesNotReported', 'submissionFacultiesData', 'verificationStatus', 'scoreTrends', 'faculties'));
    }

    public function getSubmissionsByDepartment(Request $request)
    {
        $facultyId = $request->input('faculty_id', Faculty::where('name', 'Teknik')->first()->id);

        $submissionData = IKU7::whereHas('user.prodi', function ($query) use ($facultyId) {
            $query->where('faculty_id', $facultyId);
        })
            ->with('user.prodi')
            ->get()
            ->groupBy('user.prodi.name')
            ->map(function ($items) {
                return $items->count();
            });

        return response()->json($submissionData);
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
