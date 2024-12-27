<?php

namespace App\Http\Controllers;

use App\Helpers\PeriodHelper;
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

        $currentPeriod = PeriodHelper::getCurrentPeriod();

        $totalDepartmentsWithAccounts = User::has('prodi')->count();
        $totalCourses = Course::where('period_id', $currentPeriod)->count();
        $totalCoursesReported = $this->getTotalCoursesReported();
        $totalCoursesNotReported = $this->getTotalCoursesNotReported();

        $submissionFacultiesData = IKU7::whereNot('status_verifikasi', 'draft')
            ->where('period_id', $currentPeriod)
            ->get()
            ->groupBy(function ($iku) {
                return $iku->mataKuliah->prodi->fakultas->name;
            })
            ->map(function ($items) {
                return $items->count();
            });
            
        $verificationStatus = IKU7::select('status_verifikasi')
            ->selectRaw('COUNT(*) as total')
            ->where('period_id', $currentPeriod)
            ->groupBy('status_verifikasi')
            ->get();

        $scoreTrends = Period::with([
            'pelaporanIku' => function ($query) use ($currentPeriod) {
                $query->where('period_id', $currentPeriod)
                    ->selectRaw('period_id, AVG(score_case_method + score_project_based + score_cognitive_task + score_cognitive_quiz + score_cognitive_uts + score_cognitive_uas) as avg_score')
                    ->groupBy('period_id');
            },
        ])->get();

        $faculties = Faculty::all();

        return view('dashboard.index', compact('totalCourses', 'totalDepartmentsWithAccounts', 'totalCoursesReported', 'totalCoursesNotReported', 'submissionFacultiesData', 'verificationStatus', 'scoreTrends', 'faculties'));
    }

    public function getSubmissionsByDepartment(Request $request)
    {
        $currentPeriod = PeriodHelper::getCurrentPeriod();
        $facultyId = $request->input('faculty_id', Faculty::where('name', 'Teknik')->first()->id);

        $submissionData = IKU7::whereHas('mataKuliah.prodi', function ($query) use ($facultyId, $currentPeriod) {
            $query->where('faculty_id', $facultyId)->where('period_id', $currentPeriod);
        })
            ->whereNot('status_verifikasi', 'draft')
            ->with('mataKuliah.prodi')
            ->get()
            ->groupBy(function ($iku) {
                return $iku->mataKuliah->prodi->name;
            })
            ->map(function ($items) {
                return $items->count();
            });

        return response()->json($submissionData);
    }

    public function getIKUDataByFaculty()
    {
        $currentPeriod = PeriodHelper::getCurrentPeriod();
        $ikuData = IKU7::with('mataKuliah.prodi.fakultas')
            ->where('period_id', $currentPeriod)
            ->get()
            ->groupBy(function ($iku) {
                return $iku->mataKuliah->prodi->fakultas->name;
            })
            ->map(function ($items) {
                return [
                    'proses_verifikasi' => $items->where('status_verifikasi', 'pending')->count(),
                    'terverifikasi' => $items->where('status_verifikasi', 'approved')->count(),
                    'revisi' => $items->where('status_verifikasi', 'rejected')->count(),
                    'draft' => $items->where('status_verifikasi', 'draft')->count(),
                    'total_mata_kuliah' => $items->count(),
                ];
            });

        return response()->json($ikuData);
    }

    public function getIKUDataByDepartment(Request $request)
    {
        $currentPeriod = PeriodHelper::getCurrentPeriod();
        $facultyId = $request->input('faculty_id', Faculty::first()->id);

        $ikuData = IKU7::whereHas('mataKuliah.prodi', function ($query) use ($facultyId, $currentPeriod) {
            $query->where('faculty_id', $facultyId)->where('period_id', $currentPeriod);
        })
            ->with('mataKuliah.prodi')
            ->get()
            ->groupBy(function ($iku) {
                return $iku->mataKuliah->prodi->name;
            })
            ->map(function ($items) {
                return [
                    'proses_verifikasi' => $items->where('status_verifikasi', 'pending')->count(),
                    'terverifikasi' => $items->where('status_verifikasi', 'approved')->count(),
                    'revisi' => $items->where('status_verifikasi', 'rejected')->count(),
                    'draft' => $items->where('status_verifikasi', 'draft')->count(),
                    'total_mata_kuliah' => $items->count(),
                ];
            });

        return response()->json($ikuData);
    }

    private function getTotalCoursesReported()
    {
        return IKU7::where('status_verifikasi', '!=', 'draft')->where('period_id', PeriodHelper::getCurrentPeriod())->count();
    }

    private function getTotalCoursesNotReported()
    {
        return IKU7::where('status_verifikasi', '=', 'draft')->where('period_id', PeriodHelper::getCurrentPeriod())->count();
    }
}
