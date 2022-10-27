<?php

namespace App\Infra\Repository;

use App\Model\Entity\User;
use App\Model\Repository\UserRepositoryInterface;

/**
 * ユーザリポジトリ
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * データベース
     * 
     * @var Database
     */
    private Database $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * ユーザIDからユーザを1件取得
     *
     * @param integer $userId
     * @return User|null
     */
    public function findOneById(int $userId): ?User
    {
        $data = $this->db->fetch(
            "SELECT * FROM users WHERE id = :id",
            [
                "id" => $userId
            ]
        );
        return $data ? new User(
            id: $data["id"],
            nickname: $data["nickname"],
            email: $data["email"],
            password: $data["password"],
            isPasswordEncrypted: true
        ) : null;
    }

    /**
     * メールアドレスからユーザを1件取得
     *
     * @param string $email
     * @return User|null
     */
    public function findOneByEmail(string $email): ?User
    {
        $data = $this->db->fetch(
            "SELECT * FROM users WHERE email = :email",
            [
                "email" => $email
            ]
        );
        return $data ? new User(
            id: $data["id"],
            nickname: $data["nickname"],
            email: $data["email"],
            password: $data["password"],
            isPasswordEncrypted: true
        ) : null;
    }

    /**
     * ユーザの保存
     *
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        if ($user->hasId()) {
            $userId = $this->update($user);
        } else {
            $userId = $this->create($user);
        }
        return $this->findOneById($userId);
    }

    /**
     * ユーザの削除
     *
     * @param integer $userId
     * @return void
     */
    public function delete(int $userId)
    {
        $this->db->execute(
            "DELETE FROM users WHERE id = :id",
            [
                "id" => $userId
            ]
        );
    }

    /**
     * ユーザの作成
     *
     * @param User $user
     * @return integer ユーザID
     */
    private function create(User $user): int
    {
        $this->db->execute(
            "INSERT INTO users (nickname, email, password) VALUES (:nickname, :email, :password)",
            [
                "nickname" => $user->nickname,
                "email" => $user->email,
                "password" => $user->encryptPassword()
            ]
        );
        return $this->db->getLastInsertId();
    }

    /**
     * ユーザの更新
     *
     * @param User $user
     * @return integer ユーザID
     */
    private function update(User $user): int
    {
        if ($user->hasRawPassword()) {
            $this->db->execute(
                "UPDATE users SET nickname = :nickname, email = :email, password = :password WHERE id = :id",
                [
                    "id" => $user->id,
                    "nickname" => $user->nickname,
                    "email" => $user->email,
                    "password" => $user->encryptPassword()
                ]
            );
        } else {
            $this->db->execute(
                "UPDATE users SET nickname = :nickname, email = :email WHERE id = :id",
                [
                    "id" => $user->id,
                    "nickname" => $user->nickname,
                    "email" => $user->email
                ]
            );
        }
        return $user->id;
    }

    /**
     * トランザクション
     *
     * @param \Closure $callback
     * @return void
     */
    public function atomic(\Closure $callback)
    {
        $this->db->beginTransaction();
        try {
            call_user_func($callback);
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
