<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class AdminAttendanceController extends Controller
{
    /**
     * Display the attendance management dashboard with CRUD functionality.
     */
    public function index(Request $request)
    {
        // 1. Resolve session scope (from query parameter or cache fallback)
        $sessionName = $request->query('session');
        if (! in_array($sessionName, ['HARI_1', 'HARI_2'])) {
            $sessionName = Cache::get('global_active_session', 'HARI_1');
        }

        // 2. Fetch filters
        $filterAgency = $request->query('agency', 'all');
        $filterStatus = $request->query('status', 'all');
        $search = $request->query('search');

        // Fetch all unique agencies for dropdown
        $agencies = User::whereJsonContains('roles', 'peserta')
            ->whereNotNull('agency')
            ->distinct()
            ->orderBy('agency')
            ->pluck('agency');

        // Fetch all participants for the Add Modal
        $participants = User::whereJsonContains('roles', 'peserta')
            ->orderBy('name')
            ->get(['id', 'name']);

        // 3. Build query with eager loading (N+1 prevention)
        $query = User::whereJsonContains('roles', 'peserta')
            ->with(['attendances' => function ($q) use ($sessionName) {
                $q->where('session_name', $sessionName);
            }])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%")
                      ->orWhere('agency', 'like', "%{$search}%");
                });
            })
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
            'filterStatus',
            'search',
            'participants'
        ));
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                // Composite uniqueness: prevent double-booking a session
                Rule::unique('attendances')->where(function ($query) use ($request) {
                    return $query->where('session_name', $request->session_name);
                }),
            ],
            'session_name' => ['required', 'string', 'in:HARI_1,HARI_2'],
            'scanned_at'   => ['nullable', 'date'],
        ], [
            'user_id.unique' => 'Peserta ini sudah mempunyai rekod kehadiran untuk sesi ini.',
            'user_id.exists' => 'Peserta tidak dijumpai dalam sistem.',
            'session_name.in' => 'Sesi yang dipilih tidak sah.',
        ]);

        Attendance::create([
            'user_id'      => $validated['user_id'],
            'session_name' => $validated['session_name'],
            'scanned_at'   => $validated['scanned_at'] ?? now(),
        ]);

        return redirect()->back()->with('success', 'Rekod kehadiran berjaya ditambah.');
    }

    /**
     * Update the specified attendance record.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                // Ignore current record when checking uniqueness
                Rule::unique('attendances')->where(function ($query) use ($request) {
                    return $query->where('session_name', $request->session_name);
                })->ignore($attendance->id),
            ],
            'session_name' => ['required', 'string', 'in:HARI_1,HARI_2'],
            'scanned_at'   => ['nullable', 'date'],
        ], [
            'user_id.unique' => 'Peserta ini sudah mempunyai rekod kehadiran untuk sesi ini.',
            'user_id.exists' => 'Peserta tidak dijumpai dalam sistem.',
            'session_name.in' => 'Sesi yang dipilih tidak sah.',
        ]);

        $attendance->update([
            'user_id'      => $validated['user_id'],
            'session_name' => $validated['session_name'],
            'scanned_at'   => $validated['scanned_at'] ?? $attendance->scanned_at,
        ]);

        return redirect()->back()->with('success', 'Rekod kehadiran berjaya dikemas kini.');
    }

    /**
     * Delete the specified attendance record.
     */
    public function destroy(Attendance $attendance)
    {
        $participantName = $attendance->user->name ?? 'N/A';
        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => "Rekod kehadiran untuk {$participantName} berjaya dipadam.",
        ]);
    }
}
