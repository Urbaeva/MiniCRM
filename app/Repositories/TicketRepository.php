<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
	public function create(array $data): Ticket
	{
		return Ticket::query()->create($data);
	}

	public function countForPeriod(int $days): int
	{
		return Ticket::createdLastDays($days)->count();
	}

	public function countByStatusForPeriod(int $days): int
	{
		return Ticket::createdLastDays($days)
			->selectRaw('status, COUNT(*) as count')
			->groupBy('status')
			->pluck('count', 'status')
			->toArray();
	}
}