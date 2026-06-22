<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    /**
     * Display the admin attendance monitoring dashboard.
     */
    public function dashboard(Request $request)
    {
        // 1. Resolve session day dynamically (from query parameter or cache fallback)
        $sessionName = $request->query('day');
        if (! in_array($sessionName, ['HARI_1', 'HARI_2'])) {
            $sessionName = Cache::get('global_active_session', 'HARI_1');
        }

        // 2. Calculate statistics
        $totalRegistered = User::whereJsonContains('roles', 'peserta')->count();
        
        $presentUsers = User::whereJsonContains('roles', 'peserta')
            ->whereHas('attendances', function ($query) use ($sessionName) {
                $query->where('session_name', $sessionName);
            })->get();

        $absentUsers = User::whereJsonContains('roles', 'peserta')
            ->whereDoesntHave('attendances', function ($query) use ($sessionName) {
                $query->where('session_name', $sessionName);
            })->get();

        $totalPresent = $presentUsers->count();
        $totalAbsent = $totalRegistered - $totalPresent;

        return view('admin.dashboard', compact(
            'totalRegistered',
            'totalPresent',
            'totalAbsent',
            'presentUsers',
            'absentUsers',
            'sessionName'
        ));
    }

    /**
     * Display a paginated list of all users with optional search.
     */
    public function indexUsers(Request $request)
    {
        $search = $request->query('search');

        $users = User::orderBy('name')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%")
                      ->orWhere('agency', 'like', "%{$search}%");
                });
            })
            ->paginate(15)
            ->appends(['search' => $search]);

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Store a newly created user.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'agency' => ['required', 'string', 'max:255'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', 'in:admin,jawatankuasa,peserta'],
        ]);

        User::create([
            'name' => $request->name,
            'position' => $request->position,
            'agency' => $request->agency,
            'roles' => $request->roles,
            'is_eligible_cert' => $request->has('is_eligible_cert'),
            'has_received_doorgift' => $request->boolean('has_received_doorgift'),
        ]);

        return redirect()->back()->with('success', 'Peserta baru berjaya didaftarkan.');
    }

    /**
     * Update the specified user.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'agency' => ['required', 'string', 'max:255'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', 'in:admin,jawatankuasa,peserta'],
        ]);

        $user->update([
            'name' => $request->name,
            'position' => $request->position,
            'agency' => $request->agency,
            'roles' => $request->roles,
            'is_eligible_cert' => $request->has('is_eligible_cert'),
            'has_received_doorgift' => $request->boolean('has_received_doorgift'),
        ]);

        return redirect()->back()->with('success', 'Maklumat pengguna berjaya dikemas kini.');
    }

    /**
     * Set the doorgift received status for any user.
     * Endpoint: PATCH /admin/users/{id}/doorgift
     * Restricted to: admin middleware (enforced at route level)
     */
    public function setDoorgift(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $user = User::findOrFail($id);

        // Direct write. Idempotent. Safe against double-clicks.
        $user->update(['has_received_doorgift' => $request->boolean('status')]);

        return response()->json([
            'success' => true,
            'has_received_doorgift' => $user->has_received_doorgift,
            'participant_name' => $user->name,
        ]);
    }

    /**
     * Delete the specified user.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent self-deletion
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak boleh memadam akaun anda sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berjaya dipadam.');
    }

    /**
     * Display evaluation analytics with aggregated data for charts.
     */
    public function evaluationAnalytics()
    {
        $evaluations = Evaluation::all();
        $totalResponses = $evaluations->count();

        // Section B: Average scores for b1 through b10
        $bFields = ['b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8', 'b9', 'b10'];
        $bAverages = [];
        foreach ($bFields as $field) {
            $bAverages[$field] = $totalResponses > 0 ? round($evaluations->avg($field), 2) : 0;
        }

        // Section C: Average scores for speakers
        $cFields = [
            'c2_fuad_bee' => 'Datuk Mohd Fuad Bee Bin Haji Basah, JP',
            'c1_idris_jala' => 'Dato\' Sri Idris Jala',
            'c3_petrus_gimbad' => 'Datuk Petrus Gimbad',
            'c6_saravana_kumar' => 'Dato\' S Saravana Kumar',
            'c4_lee_min_onn' => 'Encik Lee Min Onn',
            'c5_khairunnizat' => 'Encik Mohamad Khairunnizat Bin Khori',
        ];
        $cAverages = [];
        foreach ($cFields as $field => $label) {
            $cAverages[$field] = [
                'label' => $label,
                'average' => $totalResponses > 0 ? round($evaluations->avg($field), 2) : 0,
            ];
        }

        // Section E: Rating distribution for overall program
        $eDistribution = [
            1 => $evaluations->where('e_overall', 1)->count(),
            2 => $evaluations->where('e_overall', 2)->count(),
            3 => $evaluations->where('e_overall', 3)->count(),
            4 => $evaluations->where('e_overall', 4)->count(),
            5 => $evaluations->where('e_overall', 5)->count(),
        ];
        $eAverage = $totalResponses > 0 ? round($evaluations->avg('e_overall'), 2) : 0;

        // Section D: Collect all text responses (non-null)
        $textResponses = $evaluations->map(function ($eval) {
            return [
                'user' => $eval->user->name ?? 'N/A',
                'd1' => $eval->d1_beneficial,
                'd2' => $eval->d2_improvements,
                'd3' => $eval->d3_future_topics,
            ];
        })->filter(function ($item) {
            return $item['d1'] || $item['d2'] || $item['d3'];
        })->values();

        // Section F: Future interest stats
        $fInterestedCount = $evaluations->where('f_interested', true)->count();

        $isFormOpen = Cache::get('evaluation_status', false);

        // Attendance frequency distribution (0 Sesi, 1 Sesi, 2 Sesi)
        // Step 1: Build a raw subquery — toBase() strips Eloquent model hydration,
        //         withCount() produces a LEFT JOIN subselect for attendances_count.
        $subquery = User::whereJsonContains('roles', 'peserta')
            ->withCount('attendances')
            ->toBase();

        // Step 2: Wrap in DB::table() to aggregate entirely inside the database engine.
        //         MySQL returns at most 3 rows (counts for 0, 1, 2) regardless of participant volume.
        $attendanceDistribution = DB::table($subquery, 'sub')
            ->select('attendances_count', DB::raw('COUNT(*) as total_users'))
            ->groupBy('attendances_count')
            ->pluck('total_users', 'attendances_count');

        // Step 3: Populate Chart.js arrays
        $maxSessions = 2; // HARI_1, HARI_2
        $attendanceFreqLabels = [];
        $attendanceFreqData = [];
        for ($i = 0; $i <= $maxSessions; $i++) {
            $attendanceFreqLabels[] = $i . ' Sesi';
            $attendanceFreqData[] = $attendanceDistribution->get($i, 0);
        }

        return view('admin.evaluation_analytics', compact(
            'totalResponses',
            'bAverages',
            'cAverages',
            'eDistribution',
            'eAverage',
            'textResponses',
            'fInterestedCount',
            'isFormOpen',
            'attendanceFreqLabels',
            'attendanceFreqData'
        ));
    }

    /**
     * Export all evaluation data as a streamed CSV download.
     */
    public function exportCsv(): StreamedResponse
    {
        $evaluations = Evaluation::with('user')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="evaluations_bod_2026.csv"',
        ];

        return response()->stream(function () use ($evaluations) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV Header Row
            fputcsv($handle, [
                'Nama', 'Agensi', 'No. Telefon',
                'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10',
                'C1 - Fuad Bee', 'C2 - Idris Jala', 'C3 - Petrus Gimbad',
                'C4 - Saravana Kumar', 'C5 - Lee Min Onn', 'C6 - Khairunnizat',
                'D1 - Bermanfaat', 'D2 - Penambahbaikan', 'D3 - Topik Masa Depan',
                'E - Keseluruhan',
                'F - Berminat', 'F - Bidang',
                'Tarikh Hantar',
            ]);

            // CSV Data Rows
            foreach ($evaluations as $eval) {
                fputcsv($handle, [
                    $eval->user->name ?? 'N/A',
                    $eval->user->agency ?? 'N/A',
                    $eval->user->phone_number ?? 'N/A',
                    $eval->b1, $eval->b2, $eval->b3, $eval->b4, $eval->b5,
                    $eval->b6, $eval->b7, $eval->b8, $eval->b9, $eval->b10,
                    $eval->c2_fuad_bee, $eval->c1_idris_jala, $eval->c3_petrus_gimbad,
                    $eval->c6_saravana_kumar, $eval->c4_lee_min_onn, $eval->c5_khairunnizat,
                    $eval->d1_beneficial, $eval->d2_improvements, $eval->d3_future_topics,
                    $eval->e_overall,
                    $eval->f_interested ? 'Ya' : 'Tidak',
                    $eval->f_field,
                    $eval->created_at?->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Toggle the evaluation form status (open or close).
     */
    public function toggleEvaluation(Request $request)
    {
        $status = $request->input('status');

        if ($status === 'open') {
            Cache::forever('evaluation_status', true);
            return redirect()->back()->with('success', 'Akses borang penilaian telah DIBUKA.');
        } else {
            Cache::forever('evaluation_status', false);
            return redirect()->back()->with('success', 'Akses borang penilaian telah DITUTUP.');
        }
    }

    /**
     * Display the attendance management dashboard.
     */
    public function indexAttendance(Request $request)
    {
        // 1. Resolve session scope (from query parameter or cache fallback)
        $sessionName = $request->query('session');
        if (! in_array($sessionName, ['HARI_1', 'HARI_2'])) {
            $sessionName = Cache::get('global_active_session', 'HARI_1');
        }

        // 2. Fetch filters
        $filterAgency = $request->query('agency', 'all');
        $filterStatus = $request->query('status', 'all');

        // Fetch all unique agencies for dropdown
        $agencies = User::whereJsonContains('roles', 'peserta')
            ->whereNotNull('agency')
            ->distinct()
            ->orderBy('agency')
            ->pluck('agency');

        // 3. Build query with eager loading (N+1 prevention)
        $query = User::whereJsonContains('roles', 'peserta')
            ->with('attendances')
            ->orderBy('name');

        // Apply Agency Filter
        if ($filterAgency !== 'all') {
            $query->where('agency', $filterAgency);
        }

        // Apply Status Filter
        if ($filterStatus === 'hadir') {
            $query->whereHas('attendances', function ($q) use ($sessionName) {
                $q->where('session_name', $sessionName);
            });
        } elseif ($filterStatus === 'tidak_hadir') {
            $query->whereDoesntHave('attendances', function ($q) use ($sessionName) {
                $q->where('session_name', $sessionName);
            });
        }

        $allParticipants = $query->get();

        // 4. Calculate session-scoped metrics (based on filtered list)
        $totalRegistered = $allParticipants->count();

        $totalPresent = $allParticipants->filter(function ($user) use ($sessionName) {
            return $user->attendances->contains('session_name', $sessionName);
        })->count();

        $totalAbsent = $totalRegistered - $totalPresent;

        // 5. Group by agency
        $groupedByAgency = $allParticipants->groupBy('agency');

        return view('admin.attendance.index', compact(
            'totalRegistered',
            'totalPresent',
            'totalAbsent',
            'groupedByAgency',
            'sessionName',
            'agencies',
            'filterAgency',
            'filterStatus'
        ));
    }

    /**
     * Export attendance data as PDF based on active filters.
     */
    public function exportAttendancePdf(Request $request)
    {
        // 1. Resolve session scope (from query parameter or cache fallback)
        $sessionName = $request->query('session');
        if (! in_array($sessionName, ['HARI_1', 'HARI_2'])) {
            $sessionName = Cache::get('global_active_session', 'HARI_1');
        }

        // 2. Resolve filters
        $status = $request->query('status', 'all');
        $agency = $request->query('agency', 'all');

        // 3. Build base query with eager loading (N+1 prevention)
        $query = User::whereJsonContains('roles', 'peserta')
            ->with('attendances')
            ->orderBy('name');

        if ($agency !== 'all') {
            $query->where('agency', $agency);
            $agencyLabel = $agency;
        } else {
            $agencyLabel = 'Semua Agensi';
        }

        // 4. Apply session-scoped status filter
        switch ($status) {
            case 'hadir':
                $query->whereHas('attendances', function ($q) use ($sessionName) {
                    $q->where('session_name', $sessionName);
                });
                $title = 'SENARAI PESERTA HADIR';
                break;
            case 'tidak_hadir':
                $query->whereDoesntHave('attendances', function ($q) use ($sessionName) {
                    $q->where('session_name', $sessionName);
                });
                $title = 'SENARAI PESERTA TIDAK HADIR';
                break;
            default:
                $status = 'all';
                $title = 'SENARAI KEHADIRAN PENUH';
                break;
        }

        $users = $query->get();

        // 5. Session label for PDF subtitle
        $sessionLabel = $sessionName === 'HARI_1' ? 'Hari 1' : 'Hari 2';

        // 6. Render and stream PDF
        $pdf = Pdf::loadView('admin.reports.attendance_pdf', compact(
            'users', 'title', 'sessionName', 'sessionLabel', 'agencyLabel'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream("kehadiran_{$status}_{$sessionName}.pdf");
    }

    /**
     * Toggle the global active session (HARI_1 or HARI_2).
     */
    public function toggleGlobalSession(Request $request)
    {
        $request->validate([
            'session' => ['required', 'string', 'in:HARI_1,HARI_2'],
        ]);

        Cache::forever('global_active_session', $request->session);

        return redirect()->back()->with('success', 'Sesi aktif global berjaya dikemas kini kepada ' . ($request->session === 'HARI_1' ? 'Hari 1' : 'Hari 2') . '.');
    }
}
