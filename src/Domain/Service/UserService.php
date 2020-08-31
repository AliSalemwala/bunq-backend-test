<?php

namespace App\Domain\Service;

use App\Domain\Data\UserData;
use App\Domain\Service\BaseService;
use App\Domain\Repository\UserRepository;

class UserService extends BaseService {
    /**
     * @param UserRepository
     */
    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param array
     * @return UserData
     */
    public function createUser(array $data): UserData {
        $username = $this->resolveParam ($data, 'username');
        $userId = $this->repository->insertUser($username);
        return new UserData ($userId, $username);
    }
}