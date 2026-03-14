<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketFilterRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
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

	public function show(int $id): View
	{
		$ticket = $this->ticketService->getTicketById($id);
		return view('admin.tickets.show', compact('ticket'));
	}

	public function updateStatus(UpdateTicketStatusRequest $request, int $id): RedirectResponse
	{
		$this->ticketService->updateTicketStatus($id, $request->validated('status'));

		return redirect()
			->route('admin.tickets.show', $id)
			->with('success', 'Статус заявки обновлён.');
	}

}
