<?php

namespace App\Http\Controllers;

use App\Models\IKU7;
use App\Helpers\PeriodHelper;

class DashboardProdiController extends Controller
{
    public function index()
    {
        $currentPeriodId = PeriodHelper::getCurrentPeriod();

        $verificationStatus = IKU7::select('status_verifikasi')->selectRaw('COUNT(*) as total')->where('period_id', $currentPeriodId)->groupBy('status_verifikasi')->get();

        $averageScores = IKU7::selectRaw('AVG(score_case_method) as avg_case_method')->selectRaw('AVG(score_project_based) as avg_project_based')->selectRaw('AVG(score_cognitive_task) as avg_cognitive_task')->where('period_id', $currentPeriodId)->first();

        $averageScores = IKU7::selectRaw('AVG(score_case_method) as avg_case_method')->selectRaw('AVG(score_project_based) as avg_project_based')->selectRaw('AVG(score_cognitive_task) as avg_cognitive_task')->selectRaw('AVG(score_cognitive_quiz) as avg_cognitive_quiz')->selectRaw('AVG(score_cognitive_uts) as avg_cognitive_uts')->selectRaw('AVG(score_cognitive_uas) as avg_cognitive_uas')->where('period_id', $currentPeriodId)->first();

        $verificationByDepartment = IKU7::select('department_id', 'status_verifikasi')->selectRaw('COUNT(*) as total')->where('period_id', $currentPeriodId)->groupBy('department_id', 'status_verifikasi')->with('user')->get();

        $scoreTrends = IKU7::selectRaw('period_id')->selectRaw('AVG(score_case_method) as avg_case_method')->selectRaw('AVG(score_project_based) as avg_project_based')->selectRaw('AVG(score_cognitive_task) as avg_cognitive_task')->groupBy('period_id')->with('periode')->get();

        return view('dashboard.pelaporan-prodi.dashboard', compact('currentPeriodId', 'verificationStatus', 'averageScores', 'averageScores', 'verificationByDepartment', 'scoreTrends'));
    }
}
