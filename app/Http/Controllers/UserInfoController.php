<?php

namespace App\Http\Controllers;

use App\Services\Repositories\UserInfoRepository;
use App\Services\UserInfoService;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    protected $userInfoRepository;
    protected $userInfoService;

    public function __construct(UserInfoRepository $userInfoRepository, UserInfoService $userInfoService)
    {
        $this->userInfoRepository = $userInfoRepository;
        $this->userInfoService = $userInfoService;
    }

    public function index(UserInfoService $userInfoService)
    {
        $allUserInfo = $userInfoService->userInfos();
        return $allUserInfo;
    }

}
