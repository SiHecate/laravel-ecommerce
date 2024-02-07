<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserInfoService;
use App\Http\Requests\UserInfoRequest;
use App\Services\Repositories\UserInfoRepository;

class UserInfoController extends Controller
{
    protected $userInfoRepository;
    protected $userInfoService;

    public function __construct(UserInfoRepository $userInfoRepository, UserInfoService $userInfoService)
    {
        $this->userInfoRepository = $userInfoRepository;
        $this->userInfoService = $userInfoService;
    }

    public function index()
    {
        $allUserInfo = $this->userInfoService->userInfos();
        return $allUserInfo;
    }

    public function show(Request $request)
    {
        $userId = $request->user()->id;
        return $this->userInfoService->getUserInfos($userId);
    }

    // Store Request güncellenecek.
    public function store(UserInfoRequest $request)
    {
        $validatedData = $request->validate();
        $userId = $request->user()->id;
        return $this->userInfoService->createUserInfo($validatedData, $userId);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validated();
        $userId = $request->user()->id;
        return $this->userInfoService->updateUserInfo($validatedData, $userId);
    }

    public function delete(UserInfoRequest $request)
    {
        $validatedData = $request->validated();
        $userId = $request->user()->id;
        $addressName = $validatedData['address_name'];
        return $this->userInfoService->deleteUserInfo($addressName, $userId);
    }
}
