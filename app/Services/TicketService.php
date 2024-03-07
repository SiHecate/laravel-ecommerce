<?php

namespace App\Services;

use App\Models\Inbox;
use App\Models\TicketUser;
use App\Models\TicketAdmin;
use PhpParser\Node\Stmt\Foreach_;

class TicketService {
    public function createTicket($userId, array $data){
        $ticketId = $this->generateTicketId();
        $ticketData = [
            'user_id' => $userId,
            'ticket_id' => $ticketId,
            'title' => $data['title'],
            'desc' => $data['desc'],            
        ];
        TicketUser::create($ticketData);
        $this->generateResponse($ticketId); 
        return response()->json($ticketData);
    }

    public function respondToTicket(array $data){
        $responseId = $data['response_id'];
        if (!$responseId) {
            return response()->json(['message' => 'Ticket data not found'], 404);
        }
        TicketAdmin::where('response_id', $responseId)->update([
            'title' => $data['title'],
            'desc' => $data['desc'],
        ]);
        $ticketId = $responseId - 1;
        TicketUser::where('ticket_id', $ticketId)->update(['status' => true]);
        $this->generateInbox($responseId, $ticketId);

        return($this->getTicketData($responseId));
    }

    public function getTicketData($responseId)
    {
        $ticketId = $responseId - 1;
        $responseData = TicketAdmin::where('response_id', $responseId)->first();
        $ticketData = TicketUser::where('ticket_id', $ticketId)->first();
        if (!$responseData || !$ticketData) {
            return response()->json(['message' => 'Ticket data not found'], 404);
        }
        $data = [
            'user_id' => $ticketData->user_id,
            'ticket_id' => $ticketId,
            'response_id' => $responseId,
            'ticket_title' => $ticketData->title,
            'ticket_desc' => $ticketData->desc,
            'response_title' => $responseData->title,
            'response_desc' => $responseData->desc,
        ];
        return response()->json($data);
    }

    public function viewAllTickets()
    {
        $inbox = Inbox::all();
        $allTickets = [];
        foreach ($inbox as $inboxData) {          
            $ticketId = $inboxData->ticket_id;
            $responseId = $ticketId + 1;
            $ticketData = TicketUser::where('ticket_id', $ticketId)->first();
            $responseData = TicketAdmin::where('response_id', $responseId)->first();
            if ($ticketData && $responseData) {
                $data = [   
                    'user_id' => $ticketData->user_id,
                    'ticket_id' => $ticketId,
                    'response_id' => $responseId,
                    'ticket_title' => $ticketData->title,
                    'ticket_desc' => $ticketData->desc,
                    'response_title' => $responseData->title,
                    'response_desc' => $responseData->desc, 
                ];
                $allTickets[] = $data;
            }
        }
        return response()->json($allTickets);
    }
    
    public function viewUserTickets($userId)
    {
        $inbox = Inbox::all();
        $userTickets = [];
        foreach($inbox as $inboxData) {
            $ticketId = $inboxData->ticket_id;
            $ticketData = TicketUser::where('ticket_id', $ticketId)
                                    ->where('user_id', $userId)
                                    ->first();
            if($ticketData) {
                $responseId = $ticketId + 1;
                $responseData = TicketAdmin::where('response_id', $responseId)->first();
                if($responseData) {
                    $data = [
                        'user_id' => $ticketData->user_id,
                        'ticket_id' => $ticketId,
                        'response_id' => $responseId,
                        'ticket_title' => $ticketData->title,
                        'ticket_desc' => $ticketData->desc,
                        'response_title' => $responseData->title,
                        'response_desc' => $responseData->desc, 
                    ];
                    $userTickets[] = $data;
                }   
            }
        }
        return response()->json($userTickets);   
    }

    public function viewNonAnsweredTickets(){
        
    }
    
    public function generateResponse($ticketId){
        $responseId = $ticketId + 1;
        $responseData = [
            'response_id' => $responseId,
            'ticket_id' => $ticketId,
            'title' => '',
            'desc' => '',
        ];
        TicketAdmin::create($responseData);
        return $responseData;
    }
    
    public function generateInbox($response_id, $ticket_id){
        Inbox::create([
            'response_id' => $response_id,
            'ticket_id' => $ticket_id,
        ]);
    }



    public function generateTicketId(){
        $ticketId = mt_rand(100000, 999999);
        return $ticketId;
    }
}