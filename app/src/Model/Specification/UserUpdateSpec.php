<?php

namespace App\Model\Specification;

use App\Model\Entity\Entity;
use App\Model\Repository\UserRepositoryInterface;
use App\Model\Specification\Assertion;

/**
 * ユーザ更新時のエンティティ仕様定義クラス
 */
class UserUpdateSpec extends Specification
{
    /**
     * Constructor
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * バリデーションルールの定義
     *
     * @param Entity $user
     * @return void
     */
    protected function specify(Entity $user)
    {
        //ニックネーム
        $this->addRule("nickname", "Nickname", [
            new Assertion\NotBlank(),
            new Assertion\Length(max: 10)
        ]);

        //メールアドレス
        $this->addRule("email", "Email", [
            new Assertion\NotBlank(),
            new Assertion\Email(),
            new Assertion\Length(max: 50),
            new Assertion\Custom(function ($value) use ($user) {
                //重複チェック
                $duplicateUser = $this->userRepository->findOneByEmail($value);
                return ($duplicateUser && $duplicateUser->id != $user->id) ? false : true;
            }, "%s is already used.")
        ]);

        //パスワード
        $this->addRule("password", "Password", [
            new Assertion\Length(min: 6, max: 10)
        ]);
    }
}
