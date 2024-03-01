<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private $orderService;
    
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    
    public function index()
    {
        return $this->orderService->viewOrder();
    }

    public function viewUserOrder(Request $request)
    {
        $userId = $request->user()->id;

        return $this->orderService->viewUserOrder($userId);
    }

    public function orderDate()
    {
        return $this->orderService->OrderDate();            
    }
}
