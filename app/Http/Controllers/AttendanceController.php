<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AttendanceController extends Controller
{
    /**
     * Generate a temporary signed URL for check-in.
     */
    public function generateQR(Request $request)
    {
        $request->validate([
            'session_name' => ['required', 'string', 'in:HARI_1,HARI_2'],
        ]);

        $user = $request->user();

        // Generate a temporary signed URL that expires in exactly 30 seconds
        $url = URL::temporarySignedRoute(
            'attendance.scan',
            now()->addSeconds(30),
            [
                'user' => $user->id,
                'session_name' => $request->session_name,
            ]
        );

        return response()->json([
            'url' => $url,
        ]);
    }

    /**
     * Handle the check-in scan from the secretariat device.
     */
    public function scanCheckIn(Request $request, $userId, $sessionName)
    {
        // 1. Enforce that the currently authenticated scanning user is a secretariat member ('jawatankuasa')
        if (! $request->user() || !$request->user()->hasRole('jawatankuasa')) {
            return response()->json([
                'error' => 'Hanya jawatankuasa sahaja yang dibenarkan mengimbas kehadiran.'
            ], 403);
        }

        // 2. Double-check the signature validity within the controller
        if (! $request->hasValidSignature()) {
            return response()->json([
                'error' => 'Kod QR telah luput atau tidak sah.'
            ], 403);
        }

        $user = User::find($userId);
        if (! $user) {
            return response()->json([
                'error' => 'Peserta tidak dijumpai.'
            ], 404);
        }

        // Check if attendance already exists for this user and session
        $existing = Attendance::where('user_id', $userId)
            ->where('session_name', $sessionName)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Peserta sudah mendaftar hadir untuk sesi ini.',
                'participant_id' => $user->id,
                'participant_name' => $user->name,
                'has_received_doorgift' => $user->has_received_doorgift,
            ], 200);
        }

        // Create the attendance record
        Attendance::create([
            'user_id' => $userId,
            'session_name' => $sessionName,
            'scanned_at' => now(),
        ]);

        return response()->json([
            'message' => 'Kehadiran berjaya didaftarkan.',
            'participant_id' => $user->id,
            'participant_name' => $user->name,
            'has_received_doorgift' => $user->has_received_doorgift,
        ], 201);
    }

    /**
     * Set the doorgift received status for a participant.
     * Endpoint: PATCH /secretariat/users/{id}/doorgift
     * Restricted to: jawatankuasa middleware (enforced at route level)
     */
    public function setDoorgift(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            // Explicit boolean — true or false. Never a toggle.
            'status' => ['required', 'boolean'],
        ]);

        $user = User::findOrFail($id);

        // Direct write. No read-then-flip. Idempotent by design.
        $user->update(['has_received_doorgift' => $request->boolean('status')]);

        return response()->json([
            'success' => true,
            'has_received_doorgift' => $user->has_received_doorgift,
            'participant_name' => $user->name,
        ]);
    }
}
