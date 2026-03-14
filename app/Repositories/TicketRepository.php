<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
	public function create(array $data): Ticket
	{
		return Ticket::query()->create($data);
	}
}