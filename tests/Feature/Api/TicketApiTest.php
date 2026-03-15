<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_ticket_via_api(): void
    {
        $payload = [
            'name' => 'Иван Иванов',
            'email' => 'ivan@example.com',
            'phone' => '+79001234567',
            'subject' => 'Тестовая заявка',
            'body' => 'Текст тестовой заявки для проверки.',
        ];

        $response = $this->postJson('/api/tickets', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('data.subject', 'Тестовая заявка')
            ->assertJsonPath('data.status', 'new')
            ->assertJsonPath('data.customer.email', 'ivan@example.com');

        $this->assertDatabaseHas('customers', ['email' => 'ivan@example.com']);
        $this->assertDatabaseHas('tickets', ['subject' => 'Тестовая заявка']);
    }

    public function test_create_ticket_validates_required_fields(): void
    {
        $response = $this->postJson('/api/tickets', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'subject', 'body']);
    }

    public function test_create_ticket_validates_phone_e164(): void
    {
        $payload = [
            'name' => 'Тест',
            'phone' => '89001234567',
            'subject' => 'Тест',
            'body' => 'Текст',
        ];

        $response = $this->postJson('/api/tickets', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }

    public function test_create_ticket_reuses_existing_customer_by_email(): void
    {
        $customer = Customer::factory()->create(['email' => 'existing@example.com']);

        $payload = [
            'name' => 'Другое Имя',
            'email' => 'existing@example.com',
            'subject' => 'Новая заявка',
            'body' => 'Текст',
        ];

        $this->postJson('/api/tickets', $payload)->assertStatus(201);

        $this->assertCount(1, Customer::where('email', 'existing@example.com')->get());
        $this->assertCount(1, $customer->fresh()->tickets);
    }

    public function test_statistics_endpoint_returns_correct_structure(): void
    {
        Ticket::factory()->count(3)->create();

        $response = $this->getJson('/api/tickets/statistics');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'day' => ['total', 'by_status'],
                    'week' => ['total', 'by_status'],
                    'month' => ['total', 'by_status'],
                ],
            ]);
    }
}
