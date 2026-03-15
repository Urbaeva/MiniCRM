<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

	public function countByStatusForPeriod(int $days): array
	{
		return Ticket::createdLastDays($days)
			->selectRaw('status, COUNT(*) as count')
			->groupBy('status')
			->pluck('count', 'status')
			->toArray();
	}

	public function getFiltered(array $filters, int $perPage = 15): LengthAwarePaginator
	{
		$query = Ticket::query()->with('customer');

		if (!empty($filters['status'])) {
			$query->byStatus($filters['status']);
		}

		if (!empty($filters['date_from'])) {
			$query->where('created_at', '>=', $filters['date_from']);
		}

		if (!empty($filters['date_to'])) {
			$query->where('created_at', '<=', $filters['date_to']);
		}

		if (!empty($filters['email'])) {
			$query->filterByEmail($filters['email']);
		}

		if (!empty($filters['phone'])) {
			$query->filterByPhone($filters['phone']);
		}
		return $query->latest()->paginate($perPage);
	}

	public function findById(int $id): Ticket
	{
		return Ticket::query()->with(['customer', 'media'])->findOrFail($id);
	}

	public function updateStatus(Ticket $ticket, string $status): Ticket
	{
		$data = ['status' => $status];

		if (in_array($status, ['in_progress', 'resolved'])) {
			$data['manager_responded_at'] = now();
		}

		$ticket->update($data);
		return $ticket->fresh();
	}
}