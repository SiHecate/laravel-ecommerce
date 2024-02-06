<?php

namespace App\Services\Repositories;

use App\Models\UserInfo;

class UserInfoRepository implements Interfaces\UserInfoRepositoryInterface
{
    public function getAll()
    {
        return UserInfo::orderBy('created_at', 'asc')->get();
    }

    public function getUserInfos($userId)
    {
        return UserInfo::where('user_id', $userId)->get();
    }

    public function create($data)
    {
        return UserInfo::create($data);
    }

    public function update($data, $userId)
    {
        return UserInfo::where('user_id', $userId)->update($data);
    }

    public function delete($userId, $addressName)
    {
        return UserInfo::where('user_id', $userId)->where('address_name', $addressName)->delete();
    }

}
