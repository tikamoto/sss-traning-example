<?php

namespace App\Infra\Repository;

use App\Model\Entity\User;
use App\Model\Repository\ActivationRepositoryInterface;

/**
 * アプリの利用許可管理用リポジトリ
 */
class ActivationRepository implements ActivationRepositoryInterface
{
    /**
     * セッション
     *
     * @var Session
     */
    private Session $session;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * 利用許可を与えるユーザを登録
     *
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->session->set("Activation.user", $user);
    }

    /**
     * 利用許可を与えたユーザの取得
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->session->get("Activation.user");
    }

    /**
     * ユーザの利用許可を解除
     *
     * @return void
     */
    public function clearUser()
    {
        $this->session->unset("Activation.user");
    }

    /**
     * 利用許可を与えるトークンを登録
     *
     * @param string $token
     * @return void
     */
    public function setToken(string $token)
    {
        $this->session->set("Activation.token", $token);
    }

    /**
     * 利用許可を与えたトークンの取得
     *
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->session->get("Activation.token");
    }
    
    /**
     * トークンの利用許可を解除
     *
     * @return void
     */
    public function clearToken()
    {
        $this->session->unset("Activation.token");
    }
}
