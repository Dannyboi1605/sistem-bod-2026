<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoorgiftTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test secretariat can set doorgift status to true.
     */
    public function test_secretariat_can_mark_doorgift_received(): void
    {
        $secretariat = User::factory()->create([
            'roles' => ['jawatankuasa'],
        ]);

        $participant = User::factory()->create([
            'roles' => ['peserta'],
        ]);

        $participant->refresh();

        $this->assertFalse($participant->has_received_doorgift);

        $response = $this->actingAs($secretariat)
            ->patchJson("/secretariat/users/{$participant->id}/doorgift", [
                'status' => true,
            ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'has_received_doorgift' => true,
            'participant_name' => $participant->name,
        ]);

        $participant->refresh();
        $this->assertTrue($participant->has_received_doorgift);
    }

    /**
     * Test admin can toggle doorgift status both ways.
     */
    public function test_admin_can_toggle_doorgift_status(): void
    {
        $admin = User::factory()->create([
            'roles' => ['admin'],
        ]);

        $participant = User::factory()->create([
            'roles' => ['peserta'],
        ]);

        // Set to true
        $response = $this->actingAs($admin)
            ->patchJson("/admin/users/{$participant->id}/doorgift", [
                'status' => true,
            ]);

        $response->assertOk();
        $this->assertTrue($participant->refresh()->has_received_doorgift);

        // Set to false
        $response = $this->actingAs($admin)
            ->patchJson("/admin/users/{$participant->id}/doorgift", [
                'status' => false,
            ]);

        $response->assertOk();
        $this->assertFalse($participant->refresh()->has_received_doorgift);
    }

    /**
     * Test participant cannot change doorgift status.
     */
    public function test_participant_cannot_change_doorgift_status(): void
    {
        $participant = User::factory()->create([
            'roles' => ['peserta'],
        ]);

        $otherParticipant = User::factory()->create([
            'roles' => ['peserta'],
        ]);

        // Try admin endpoint
        $response = $this->actingAs($participant)
            ->patchJson("/admin/users/{$otherParticipant->id}/doorgift", [
                'status' => true,
            ]);
        $response->assertStatus(403);

        // Try secretariat endpoint
        $response = $this->actingAs($participant)
            ->patchJson("/secretariat/users/{$otherParticipant->id}/doorgift", [
                'status' => true,
            ]);
        $response->assertStatus(403);
    }
}
