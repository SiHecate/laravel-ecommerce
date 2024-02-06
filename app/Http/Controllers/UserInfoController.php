<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoRequest;
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

    public function index()
    {
        $allUserInfo = $this->userInfoService->userInfos();
        return $allUserInfo;
    }

    public function show(UserInfoRequest $request)
    {
        $userId = $request->user()->id;
        return $this->userInfoService->getUserInfos($userId);
    }

    public function store(UserInfoRequest $request)
    {
        $userId = $request->user()->id;
        $validatedData = $request->validate();
        return $this->userInfoService->createUserInfo($validatedData, $userId);
    }

    public function update(UserInfoRequest $request)
    {
        $userId = $request->user()->id;
        $validatedData = $request->validated();
        return $this->userInfoService->updateUserInfo($validatedData, $userId);
    }

    public function delete(UserInfoRequest $request)
    {
        $userId = $request->user()->id;
        $validatedData = $request->validated();
        $addressName = $validatedData['address_name'];
        return $this->userInfoService->deleteUserInfo($addressName, $userId);
    }
}
