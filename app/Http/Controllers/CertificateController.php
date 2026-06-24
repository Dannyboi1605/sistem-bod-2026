<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class CertificateController extends Controller
{
    /**
     * Generate and download the participant's certificate PDF.
     *
     * Gate: only users with is_eligible_cert = true may download.
     * The certificate overlays the participant's name onto a pre-designed
     * background image (Subheading.jpg) in A4 landscape orientation.
     *
     * Safety: A Redis concurrency limiter caps simultaneous PDF renders
     * to 10 server-wide, preventing OOM under thundering-herd conditions.
     */
    public function download()
    {
        $user = Auth::user();

        // Gate: Only eligible participants may download
        if (! $user->is_eligible_cert) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum layak untuk memuat turun sijil penyertaan.');
        }

        // Concurrency limiter: max 10 simultaneous PDF renders.
        // Extra requests wait up to 30 seconds for a slot to free up.
        return Redis::funnel('certificate-pdf-render')
            ->limit(10)
            ->releaseAfter(30)
            ->block(30)
            ->then(function () use ($user) {
                // Render PDF from Blade view
                $pdf = Pdf::loadView('participant.certificate_pdf', ['user' => $user])
                    ->setPaper('a4', 'landscape');

                // Sanitize filename: strip characters illegal in filenames
                $safeName = preg_replace('/[\/\\\\:*?"<>|]/', '', $user->name);
                $filename = "Sijil_Penyertaan_{$safeName}.pdf";

                return $pdf->download($filename);
            }, function () {
                // Timed out waiting for a slot — ask user to retry
                return redirect()->route('dashboard')
                    ->with('error', 'Pelayan sedang sibuk menjana sijil. Sila cuba semula dalam beberapa saat.');
            });
    }
}
