<?php

namespace App\Model\Service;

use App\Model\Entity\User;
use App\Model\Repository\TaskRepositoryInterface;
use App\Model\Repository\UserRepositoryInterface;
use App\Model\Specification\Exception\ValidateException;
use App\Model\Specification\UserCreateSpec;
use App\Model\Specification\UserUpdateSpec;

/**
 * ユーザサービス
 */
class UserService
{
    /**
     * Constructor
     *
     * @param UserRepositoryInterface $userRepository
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TaskRepositoryInterface $taskRepository
    ) {
    }

    /**
     * ユーザの作成
     *
     * @param array $data
     * @return User
     * @throws ValidateException
     */
    public function createUser(array $data): User
    {
        $user = new User(
            nickname: $data["nickname"] ?? "",
            email: $data["email"] ?? "",
            password: $data["password"] ?? ""
        );

        try {
            $spec = new UserCreateSpec($this->userRepository);
            $spec->validate($user);
        } catch (ValidateException $e) {
            throw $e;
        }

        return $this->userRepository->save($user);
    }

    /**
     * ユーザの更新
     *
     * @param integer $userId
     * @param array $data
     * @return User
     * @throws ValidateException
     */
    public function updateUser(int $userId, array $data): User
    {
        $user = new User(
            id: $userId,
            nickname: $data["nickname"] ?? "",
            email: $data["email"] ?? "",
            password: $data["password"] ?? ""
        );

        try {
            $spec = new UserUpdateSpec($this->userRepository);
            $spec->validate($user);
        } catch (ValidateException $e) {
            throw $e;
        }

        return $this->userRepository->save($user);
    }

    /**
     * ユーザの削除
     *
     * @param integer $userId
     * @return void
     */
    public function deleteUser(int $userId)
    {
        $this->userRepository->atomic(function () use ($userId) {
            $this->taskRepository->deleteAll($userId);
            $this->userRepository->delete($userId);
        });
    }
}
