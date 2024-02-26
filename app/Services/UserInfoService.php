<?php

namespace App\Services;
use Illuminate\Http\JsonResponse;
use App\Services\Repositories\Interfaces\UserInfoRepositoryInterface;

class UserInfoService
{
    protected $userInfoRepository;

    public function __construct(UserInfoRepositoryInterface $userInfoRepository)
    {
        $this->userInfoRepository = $userInfoRepository;
    }

    public function getAll()
    {
        return $this->userInfoRepository->getAll();
    }

    public function getUserInfos($userId): JsonResponse
    {
        $userInfos = $this->userInfoRepository->getUserInfos($userId);
        if ($userInfos->isNotEmpty()) {
            $formattedUserInfos = $userInfos->map(function ($info) {
                return [
                    'address_name' => $info->address_name,
                    'name' => $info->name,
                    'lastname' => $info->lastname,
                    'email' => $info->email,
                    'telephone' => $info->telephone,
                    'city' => $info->city,
                    'county' => $info->county,
                    'neighborhood' => $info->neighborhood,
                    'full_address' => $info->full_address
                ];
            });
            return response()->json([
                'message' => 'user_infos',
                'data' => $formattedUserInfos,
            ]);
        }
        return response()->json([
            'message' => 'user_info not found',
            'data' => [],
        ]);
    }


    public function createUserInfo(array $data, $userId): JsonResponse
    {
        $createdUserInfo = $this->userInfoRepository->create($data, $userId);
        if ($createdUserInfo) {
            return response()->json(['message' => 'User info created successfully', 'data' => $createdUserInfo], 201);
        } else {
            return response()->json(['message' => 'Failed to create user info'], 500);
        }
    }

    public function updateUserInfo(array $data, $userId): JsonResponse
    {
        $updatedUserInfo = $this->userInfoRepository->update($data, $userId);

        if ($updatedUserInfo) {
            return response()->json(['message' => 'User info updated successfully', 'userInfo' => $updatedUserInfo], 200);
        } else {
            return response()->json(['message' => 'Failed to update user info'], 500);
        }
    }

    public function deleteUserInfo($addressName, $userId): JsonResponse
    {
        $deletedUserInfo = $this->userInfoRepository->delete($userId, $addressName);

        if ($deletedUserInfo) {
            return response()->json(['message' => 'User info deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete user info'], 500);
        }
    }
 }
