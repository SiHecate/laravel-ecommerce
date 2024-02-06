<?php

namespace App\Services\Repositories\Interfaces;


interface UserInfoRepositoryInterface
{
    public function getAll();

    public function getUserInfos($userId);

    public function create(array $data);

    public function update(array $data, $userId);

    public function delete($address_name, $userId);
}
