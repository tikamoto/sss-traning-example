<?php

namespace App\Model\Entity;

use App\Config;

/**
 * ユーザエンティティ
 */
class User extends Entity
{
    /**
     * Constructor
     *
     * @param integer|null $id ユーザID
     * @param string $nickname ニックネーム
     * @param string $email メールアドレス
     * @param string $password パスワード
     * @param string $createdAt 登録日
     * @param bool $isPasswordEncrypted パスワードが暗号化されているか
     */
    public function __construct(
        protected ?int $id = null,
        protected string $nickname = "",
        protected string $email = "",
        protected string $password = "",
        protected bool $isPasswordEncrypted = false
    ) {
    }

    /**
     * パスワードハッシュを生成
     *
     * @param string|null $salt
     * @return void
     * @throws \DomainException
     */
    public function encryptPassword(?string $salt = "")
    {
        if (!$this->hasRawPassword()) {
            throw new \DomainException();
        }
        return hash("sha256", $salt . $this->password);
    }

    /**
     * ユーザIDを持っているか
     *
     * @return boolean
     */
    public function hasId(): bool
    {
        return !empty($this->id);
    }

    /**
     * 平文パスワードを持っているか
     *
     * @return boolean
     */
    public function hasRawPassword(): bool
    {
        return $this->isPasswordEncrypted == false && $this->password != "";
    }
}
