<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class EvaluationToggleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear cache before each test
        Cache::forget('evaluation_status');
    }

    /**
     * Test participant cannot access GET /evaluation when locked.
     */
    public function test_participant_cannot_access_evaluation_when_locked(): void
    {
        $participant = User::factory()->create([
            'roles' => ['peserta'],
        ]);

        $response = $this->actingAs($participant)->get('/evaluation');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error', 'Borang penilaian belum dibuka oleh urus setia.');
    }

    /**
     * Test participant cannot access POST /evaluation when locked.
     */
    public function test_participant_cannot_submit_evaluation_when_locked(): void
    {
        $participant = User::factory()->create([
            'roles' => ['peserta'],
        ]);

        $response = $this->actingAs($participant)->post('/evaluation', [
            'b1' => 4, 'b2' => 4, 'b3' => 4, 'b4' => 4, 'b5' => 4,
            'b6' => 4, 'b7' => 4, 'b8' => 4, 'b9' => 4, 'b10' => 4,
            'c1_idris_jala' => 4, 'c2_fuad_bee' => 4, 'c3_petrus_gimbad' => 4,
            'c4_lee_min_onn' => 4, 'c5_khairunnizat' => 4, 'c6_saravana_kumar' => 4,
            'e_overall' => 4,
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error', 'Borang penilaian belum dibuka oleh urus setia.');
    }

    /**
     * Test admin can toggle the status.
     */
    public function test_admin_can_toggle_evaluation_status(): void
    {
        $admin = User::factory()->create([
            'roles' => ['admin'],
        ]);

        // Toggle open
        $response = $this->actingAs($admin)->post('/admin/evaluation/toggle', [
            'status' => 'open',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Akses borang penilaian telah DIBUKA.');
        $this->assertTrue(Cache::get('evaluation_status', false));

        // Toggle close
        $response = $this->actingAs($admin)->post('/admin/evaluation/toggle', [
            'status' => 'close',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Akses borang penilaian telah DITUTUP.');
        $this->assertFalse(Cache::get('evaluation_status', false));
    }

    /**
     * Test participant can access and submit when unlocked.
     */
    public function test_participant_can_access_and_submit_when_unlocked(): void
    {
        $participant = User::factory()->create([
            'roles' => ['peserta'],
        ]);

        \App\Models\Attendance::create([
            'user_id' => $participant->id,
            'session_name' => 'HARI_1',
            'scanned_at' => now(),
        ]);

        \App\Models\Attendance::create([
            'user_id' => $participant->id,
            'session_name' => 'HARI_2',
            'scanned_at' => now(),
        ]);

        Cache::forever('evaluation_status', true);

        // GET should load successfully
        $response = $this->actingAs($participant)->get('/evaluation');
        $response->assertOk();
        $response->assertViewIs('evaluation.form');

        // POST submission
        $response = $this->actingAs($participant)->post('/evaluation', [
            'b1' => 4, 'b2' => 4, 'b3' => 4, 'b4' => 4, 'b5' => 4,
            'b6' => 4, 'b7' => 4, 'b8' => 4, 'b9' => 4, 'b10' => 4,
            'c1_idris_jala' => 4, 'c2_fuad_bee' => 4, 'c3_petrus_gimbad' => 4,
            'c4_lee_min_onn' => 4, 'c5_khairunnizat' => 4, 'c6_saravana_kumar' => 4,
            'd1_beneficial' => 'Sangat bagus',
            'd2_improvements' => 'Tiada',
            'd3_future_topics' => 'AI dalam kerja',
            'e_overall' => 4,
            'f_interested' => true,
            'f_field' => 'IT',
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('success');

        // Check DB updates
        $this->assertDatabaseHas('evaluations', [
            'user_id' => $participant->id,
            'd1_beneficial' => 'Sangat bagus',
        ]);

        $participant->refresh();
        $this->assertTrue($participant->is_eligible_cert);
    }
}
