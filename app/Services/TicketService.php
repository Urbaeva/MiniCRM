<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TicketService
{
	public function __construct(
		private readonly TicketRepository $ticketRepository,
		private readonly CustomerService $customerService,
	)
	{
	}

	/**
	 * @param array{name: string, phone: ?string, email: ?string, subject: string, body: string} $data
	 * @param UploadedFile[] $files
	 * @return Ticket
	 * @throws FileDoesNotExist
	 * @throws FileIsTooBig
	 */
	public function createTicket(array $data, array $files = []): Ticket
	{
		$customer = $this->customerService->findOrCreate(
			$data['name'],
			$data['phone'] ?? null,
			$data['email'] ?? null,
		);

		$ticket = $this->ticketRepository->create([
			'customer_id' => $customer->id,
			'subject' => $data['subject'],
			'body' => $data['body'],
		]);

		foreach ($files as $file) {
			$ticket->addMedia($file)->toMediaCollection('attachments');
		}

		return $ticket->load('customer');
	}

	public function getStatistics(): array
	{
		return [
			'day' => [
				'total' => $this->ticketRepository->countForPeriod(1),
				'by_status' => $this->ticketRepository->countByStatusForPeriod(1),
			],
			'week' => [
				'total' => $this->ticketRepository->countForPeriod(7),
				'by_status' => $this->ticketRepository->countByStatusForPeriod(7),
			],
			'month' => [
				'total' => $this->ticketRepository->countForPeriod(30),
				'by_status' => $this->ticketRepository->countByStatusForPeriod(30),
			],
		];
	}
}