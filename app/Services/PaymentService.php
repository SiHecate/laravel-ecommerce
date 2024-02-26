<?php

namespace App\Services;

class PaymentService
{

    protected $userInfoService;
    protected $basketService;

    public function __construct(UserInfoService $userInfoService, BasketService $basketService)
    {
        $this->userInfoService->$userInfoService;
        $this->basketService->$basketService;
    }

    public function index()
    {

    }

    public function randomNumberGenerator()
    {
        $randomNumber = "11".rand(1,999).rand(1,88)*rand(1,50);
        return $randomNumber;
    }
}
