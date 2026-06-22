<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Generate and download the participant's certificate PDF.
     *
     * Gate: only users with is_eligible_cert = true may download.
     * The certificate overlays the participant's name onto a pre-designed
     * background image (Subheading.jpg) in A4 landscape orientation.
     */
    public function download()
    {
        $user = Auth::user();

        // Gate: Only eligible participants may download
        if (! $user->is_eligible_cert) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum layak untuk memuat turun sijil penyertaan.');
        }

        // Render PDF from Blade view
        $pdf = Pdf::loadView('participant.certificate_pdf', ['user' => $user])
            ->setPaper('a4', 'landscape');

        // Sanitize filename: strip characters illegal in filenames
        $safeName = preg_replace('/[\/\\\\:*?"<>|]/', '', $user->name);
        $filename = "Sijil_Penyertaan_{$safeName}.pdf";

        return $pdf->download($filename);
    }
}
