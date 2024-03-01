<?php

namespace App\Services;

use App\Models\TicketAdmin;
use App\Models\TicketUser;
use Illuminate\Http\Request;

class TicketService {

    /*
        - Ticket_id
        - User_id
        - Title
        - Desc
        - Status
    */
    public function createTicket($userId, array $data){
        $response = [];
        $ticketId = mt_rand(100000, 999999);
        $response[] = [
            'user_id' => $userId,
            'ticket_id' => $ticketId,
            'title' => $data['title'],
            'desc' => $data['desc'],            
        ];
        TicketUser::create($response);
        $this->createResponse($ticketId);

    }


    /*
        - Response_id
        - Ticket_id
        - Response title
        - Response desc
    */
    public function createResponse($ticketId){
        $response = [];
        if ($ticketId != 999999) {
            $responseId = $ticketId + 1;
        }
        $response[] = [
            'response_id' => $responseId,
            'ticket_id' => $ticketId,
            'title' => '',
            'desc' => '',
        ];
        TicketAdmin::create($response);

        return $response;
    }

    public function response($responseId)
    {
        $response = [];
    }
}