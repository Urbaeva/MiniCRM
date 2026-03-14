<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketFilterRequest;
use App\Services\TicketService;
use Illuminate\View\View;

class TicketController extends Controller
{
	public function __construct(
		private readonly TicketService $ticketService,
	) {}

	public function index(TicketFilterRequest $request): View
	{
		$tickets = $this->ticketService->getFilteredTickets(
			$request->validated(),
			15,
		);

		return view('admin.tickets.index', compact('tickets'));
	}

}
