<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService) {   
        $this->ticketService = $ticketService;
    }

    public function ticket(TicketRequest $request) {
        $userId = $request->user()->id;
        $this->ticketService->createTicket($userId, $request->toArray());
    }

    public function response(TicketRequest $request) {
        $this->ticketService->respondToTicket($request->toArray());
    }

    public function viewTickets() {
        
    }
}
