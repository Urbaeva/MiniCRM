<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
	protected $model = Ticket::class;

    public function definition(): array
    {
	    $status = fake()->randomElement(['new', 'in_progress', 'resolved']);

	    return [
		    'customer_id' => Customer::factory(),
		    'subject' => fake()->sentence(4),
		    'body' => fake()->paragraph(3),
		    'status' => $status,
		    'manager_responded_at' => $status === 'resolved' ? fake()->dateTimeBetween('-1 month') : null,
	    ];
    }

	public function newStatus(): static
	{
		return $this->state(fn () => [
			'status' => 'new',
			'manager_responded_at' => null,
		]);
	}

	public function inProgress(): static
	{
		return $this->state(fn () => [
			'status' => 'in_progress',
			'manager_responded_at' => null,
		]);
	}

	public function resolved(): static
	{
		return $this->state(fn () => [
			'status' => 'resolved',
			'manager_responded_at' => now(),
		]);
	}
}
