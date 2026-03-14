<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\StatisticsResource;
use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TicketController extends Controller
{
    public function __construct(
		private readonly TicketService $ticketService
    ) {}

	/**
	 * @throws FileDoesNotExist
	 * @throws FileIsTooBig
	 */
	public function store(StoreTicketRequest $request): JsonResponse
	{
		$ticket = $this->ticketService->createTicket(
			$request->validated(),
			$request->file('files', []),
		);

		return (new TicketResource($ticket))
			->response()
			->setStatusCode(201);
	}

	public function statistics()
	{
		$statistics = $this->ticketService->getStatistics();
		return new StatisticsResource($statistics);
	}
}
