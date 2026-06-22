<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EvaluationController extends Controller
{
    /**
     * Show the evaluation form for the authenticated participant.
     */
    public function showForm()
    {
        $user = auth()->user();

        // Check if evaluation status is open
        if (! Cache::get('evaluation_status', false)) {
            return redirect()->route('dashboard')->with('error', 'Borang penilaian belum dibuka oleh urus setia.');
        }

        // Check if user has already submitted an evaluation
        $existing = Evaluation::where('user_id', $user->id)->first();
        if ($existing) {
            return redirect()->route('dashboard')->with('warning', 'Anda telah menghantar penilaian. Terima kasih!');
        }

        return view('evaluation.form', ['user' => $user]);
    }

    /**
     * Validate and store the evaluation submission.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Check if evaluation status is open
        if (! Cache::get('evaluation_status', false)) {
            return redirect()->route('dashboard')->with('error', 'Borang penilaian belum dibuka oleh urus setia.');
        }

        // Prevent duplicate submissions
        $existing = Evaluation::where('user_id', $user->id)->first();
        if ($existing) {
            return redirect()->route('dashboard')->with('warning', 'Anda telah menghantar penilaian. Terima kasih!');
        }

        // Strict validation: all rating fields must be integers between 1-5
        $ratingRule = ['required', 'integer', 'min:1', 'max:5'];

        $request->validate([
            // Section B
            'b1' => $ratingRule, 'b2' => $ratingRule, 'b3' => $ratingRule, 'b4' => $ratingRule, 'b5' => $ratingRule,
            'b6' => $ratingRule, 'b7' => $ratingRule, 'b8' => $ratingRule, 'b9' => $ratingRule, 'b10' => $ratingRule,
            // Section C
            'c1_idris_jala' => $ratingRule, 'c2_fuad_bee' => $ratingRule, 'c3_petrus_gimbad' => $ratingRule,
            'c4_lee_min_onn' => $ratingRule, 'c5_khairunnizat' => $ratingRule, 'c6_saravana_kumar' => $ratingRule,
            // Section D
            'd1_beneficial' => ['nullable', 'string', 'max:2000'],
            'd2_improvements' => ['nullable', 'string', 'max:2000'],
            'd3_future_topics' => ['nullable', 'string', 'max:2000'],
            // Section E
            'e_overall' => $ratingRule,
            // Section F
            'f_interested' => ['nullable'],
            'f_field' => ['nullable', 'string', 'max:500'],
        ]);

        // Sanitize text inputs
        $sanitize = fn ($val) => $val ? strip_tags(trim($val)) : null;

        Evaluation::create([
            'user_id' => $user->id,
            // Section B
            'b1' => $request->b1, 'b2' => $request->b2, 'b3' => $request->b3, 'b4' => $request->b4, 'b5' => $request->b5,
            'b6' => $request->b6, 'b7' => $request->b7, 'b8' => $request->b8, 'b9' => $request->b9, 'b10' => $request->b10,
            // Section C
            'c1_idris_jala' => $request->c1_idris_jala, 'c2_fuad_bee' => $request->c2_fuad_bee,
            'c3_petrus_gimbad' => $request->c3_petrus_gimbad, 'c4_lee_min_onn' => $request->c4_lee_min_onn,
            'c5_khairunnizat' => $request->c5_khairunnizat, 'c6_saravana_kumar' => $request->c6_saravana_kumar,
            // Section D
            'd1_beneficial' => $sanitize($request->d1_beneficial),
            'd2_improvements' => $sanitize($request->d2_improvements),
            'd3_future_topics' => $sanitize($request->d3_future_topics),
            // Section E
            'e_overall' => $request->e_overall,
            // Section F
            'f_interested' => $request->input('f_interested') == '1',
            'f_field' => $sanitize($request->f_field),
        ]);
        // Check attendance for both days before unlocking certificate
        $attendedDay1 = $user->attendances()->where('session_name', 'HARI_1')->exists();
        $attendedDay2 = $user->attendances()->where('session_name', 'HARI_2')->exists();

        if ($attendedDay1 && $attendedDay2) {
            // All 3 conditions met: Day 1 ✓, Day 2 ✓, Evaluation ✓
            $user->update(['is_eligible_cert' => true]);

            return redirect()->route('dashboard')
                ->with('success', 'Penilaian anda telah berjaya dihantar. Terima kasih!')
                ->with('cert_unlocked', true);
        }

        // Evaluation submitted but attendance incomplete — certificate stays locked
        return redirect()->route('dashboard')
            ->with('success', 'Penilaian anda telah berjaya dihantar. Terima kasih!')
            ->with('warning', 'Sijil tidak dapat dibuka kerana kehadiran anda tidak lengkap untuk kedua-dua hari.');
    }
}
