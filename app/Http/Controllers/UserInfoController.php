<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserInfoService;
use App\Http\Requests\UserInfoRequest;

class UserInfoController extends Controller
{
    protected $userInfoService;

    public function __construct(UserInfoService $userInfoService)
    {
        $this->userInfoService = $userInfoService;
    }

    public function index()
    {
        $allUserInfo = $this->userInfoService->getAll();
        return $allUserInfo;
    }

    public function show(Request $request)
    {
        $userId = $request->user()->id;
        return $this->userInfoService->getUserInfos($userId);
    }

    public function store(UserInfoRequest $request)
    {
        $validatedData = $request->validated();
        $userId = $request->user()->id;
        $response = $this->userInfoService->createUserInfo($validatedData, $userId);
        return $response;
    }

    public function update(UserInfoRequest $request)
    {
        $validatedData = $request->validated();
        $userId = $request->user()->id;
        return $this->userInfoService->updateUserInfo($validatedData, $userId);
    }

    public function delete(Request $request)
    {
        $validatedData = $request->validated();
        $userId = $request->user()->id;
        $addressName = $validatedData['address_name'];
        return $this->userInfoService->deleteUserInfo($addressName, $userId);
    }
}
