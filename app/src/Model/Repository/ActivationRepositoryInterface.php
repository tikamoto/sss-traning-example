<?php

namespace App\Model\Repository;

use App\Model\Entity\User;

/**
 * アプリの利用許可管理用リポジトリインターフェース
 */
interface ActivationRepositoryInterface
{
    /**
     * 利用許可を与えるユーザを登録
     *
     * @param User $user
     * @return void
     */
    public function setUser(User $user);

    /**
     * 利用許可を与えたユーザの取得
     *
     * @return User|null
     */
    public function getUser(): ?User;

    /**
     * ユーザの利用許可を解除
     *
     * @return void
     */
    public function clearUser();

    /**
     * 利用許可を与えるトークンを登録
     *
     * @param string $token
     * @return void
     */
    public function setToken(string $token);

    /**
     * 利用許可を与えたトークンの取得
     *
     * @return string
     */
    public function getToken(): ?string;

    /**
     * トークンの利用許可を解除
     *
     * @return void
     */
    public function clearToken();
}
