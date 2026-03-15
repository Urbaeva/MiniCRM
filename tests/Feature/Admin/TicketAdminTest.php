<?php

namespace Tests\Feature\Admin;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TicketAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $manager;

    protected function setUp(): void
    {
        parent::setUp();

        Role::findOrCreate('manager', 'web');
        $this->manager = User::factory()->create();
        $this->manager->assignRole('manager');
    }

    public function test_guest_cannot_access_admin(): void
    {
        $response = $this->get('/admin/tickets');
        $response->assertRedirect('/login');
    }

    public function test_manager_can_view_ticket_list(): void
    {
        Ticket::factory()->count(3)->create();

        $response = $this->actingAs($this->manager)->get('/admin/tickets');
        $response->assertOk();
        $response->assertViewIs('admin.tickets.index');
    }

    public function test_manager_can_view_ticket_detail(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($this->manager)->get("/admin/tickets/{$ticket->id}");
        $response->assertOk();
        $response->assertViewIs('admin.tickets.show');
    }

    public function test_manager_can_update_ticket_status(): void
    {
        $ticket = Ticket::factory()->newStatus()->create();

        $response = $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class)
            ->actingAs($this->manager)
            ->patch("/admin/tickets/{$ticket->id}/status", ['status' => 'in_progress']);

        $response->assertRedirect(route('admin.tickets.show', $ticket->id));
        $this->assertEquals('in_progress', $ticket->fresh()->status);
    }

    public function test_manager_can_filter_tickets_by_status(): void
    {
        Ticket::factory()->newStatus()->count(2)->create();
        Ticket::factory()->resolved()->count(3)->create();

        $response = $this->actingAs($this->manager)->get('/admin/tickets?status=new');
        $response->assertOk();
    }

    public function test_non_manager_user_cannot_access_admin(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/tickets');
        $response->assertStatus(403);
    }
}
