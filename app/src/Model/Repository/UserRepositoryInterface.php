<?php

namespace App\Model\Repository;

use App\Model\Entity\User;

/**
 * ユーザリポジトリインターフェース
 */
interface UserRepositoryInterface
{
    /**
     * ユーザIDからユーザを1件取得
     *
     * @param integer $userId
     * @return User|null
     */
    public function findOneById(int $userId): ?User;

    /**
     * メールアドレスからユーザを1件取得
     *
     * @param string $email
     * @return User|null
     */
    public function findOneByEmail(string $email): ?User;

    /**
     * ユーザの保存
     *
     * @param User $user
     * @return User
     */
    public function save(User $user): User;

    /**
     * ユーザの削除
     *
     * @param integer $userId
     * @return void
     */
    public function delete(int $userId);

    /**
     * トランザクション
     *
     * @param \Closure $callback
     * @return void
     */
    public function atomic(\Closure $callback);
}
