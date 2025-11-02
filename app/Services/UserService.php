<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUserInfoForFlutter($userId)
    {
        return $this->repository->getUserCompleteInfo($userId);
    }

    public function getGamificationLog($userId): array
    {
        return $this->repository->getGamificationLog($userId);
    }
}
