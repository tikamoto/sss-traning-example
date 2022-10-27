<?php

namespace App\Model\Service;

use App\Model\Entity\User;
use App\Model\Repository\ActivationRepositoryInterface;
use App\Model\Repository\UserRepositoryInterface;

/**
 * 認証/認可サービス
 */
class AuthService
{
    /**
     * Constructor
     *
     * @param ActivationRepositoryInterface $activationRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private ActivationRepositoryInterface $activationRepository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * 認証
     *
     * @param User $challengeUser
     * @return User|null
     */
    public function authenticate(User $challengeUser): ?User
    {
        $user = $this->userRepository->findOneByEmail($challengeUser->email);
        if ($user) {
            if ($challengeUser->encryptPassword() == $user->password) {
                return $user;
            }
        }
        return null;
    }

    /**
     * 認可
     *
     * @param User $user
     * @return void
     */
    public function authorize(User $user): void
    {
        $this->activationRepository->setUser($user);
    }

    /**
     * 認可取り消し
     *
     * @return void
     */
    public function deauthorize(): void
    {
        $this->activationRepository->clearUser();
    }

    /**
     * 認可済みか
     *
     * @return boolean
     */
    public function isAuthorized(): bool
    {
        $user = $this->getAuthorizedUser();
        return $user ? true : false;
    }

    /**
     * 認可済みユーザの取得
     *
     * @return User|null
     */
    public function getAuthorizedUser(): ?User
    {
        $user = $this->activationRepository->getUser();
        if ($user && $user->id) {
            $user = $this->userRepository->findOneById($user->id);
            return $user;
        }
        return null;
    }

    /**
     * ワンタイムトークンの生成
     *
     * @return string
     */
    public function generateOnetimeToken(): string
    {
        $token = bin2hex(random_bytes(20));
        $this->activationRepository->setToken($token);
        return $token;
    }

    /**
     * ワンタイムトークンの妥当性検証
     *
     * @param string $token
     * @return boolean
     */
    public function verifyOnetimeToken(string $token): bool
    {
        $authToken = $this->activationRepository->getToken();
        $this->activationRepository->clearToken();
        return $token != "" && $token === $authToken ? true : false;
    }
}
