<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoRequest;
use App\Services\Repositories\UserInfoRepository;
use App\Services\UserInfoService;

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

    public function store(UserInfoRequest $request)
    {
        dd('geldi');
        $validatedData = $request->validate();
        dd('geldi');
        $userId = $request->user()->id;
        dd('geldi');
        return $this->userInfoService->createUserInfo($validatedData, $userId);
    }

    public function update(UserInfoRequest $request)
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

    public function show(UserInfoRequest $request)
    {
        $userId = $request->user()->id;
        return $this->userInfoService->getUserInfos($userId);
    }
}
