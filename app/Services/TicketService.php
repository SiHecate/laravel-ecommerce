<?php

namespace App\Services;

use App\Models\Inbox;
use App\Models\TicketUser;
use App\Models\TicketAdmin;

class TicketService {

    public function generateTicket($userId, array $data){
        $ticketId = mt_rand(100000, 999999);
        $ticketData = [
            'user_id' => $userId,
            'ticket_id' => $ticketId,
            'title' => $data['title'],
            'desc' => $data['desc'],            
        ];
        TicketUser::create($ticketData);
        $this->generateResponse($ticketId);
        return $ticketData;
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

    public function answerResponse($responseId, array $data){
        TicketAdmin::where('response_id', $responseId)->update([
            'title' => $data['title'],
            'desc' => $data['desc'],
        ]);
        $ticketId = $responseId - 1;
        TicketUser::where('ticket_id', $ticketId)->update(['status' => true]);
        $this->generateInbox($responseId, $ticketId);
    }
}