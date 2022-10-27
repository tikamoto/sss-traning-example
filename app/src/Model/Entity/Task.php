<?php

namespace App\Model\Entity;

/**
 * タスクエンティティ
 */
class Task extends Entity
{
    /**
     * Constructor
     *
     * @param integer|null $id タスクID
     * @param integer|null $userId ユーザID
     * @param string $expiredOn 期日
     * @param string $description 概要
     * @param integer $isDone 完了済みか
     * @param string $createdAt 登録日
     */
    public function __construct(
        protected ?int $id = null,
        protected ?int $userId = null,
        protected string $expiredOn = "",
        protected string $description = "",
        protected int $isDone = 0,
        protected string $createdAt = ""
    ) {
    }

    /**
     * 期日をフォーマットを指定して取得
     *
     * @param string $format
     * @return string
     */
    public function getExpiredOn(string $format = "Y/m/d"): string
    {
        return date($format, strtotime($this->expiredOn));
    }

    /**
     * 期日が過ぎているか（当日含む）
     *
     * @return boolean
     */
    public function isExpired(): bool
    {
        return strtotime(date('Y-m-d')) >= strtotime($this->expiredOn);
    }

    /**
     * 完了状態か
     *
     * @return boolean
     */
    public function isDone(): bool
    {
        return !!$this->isDone;
    }

    /**
     * 完了状態にする
     *
     * @return void
     */
    public function done()
    {
        $this->isDone = 1;
    }

    /**
     * 未完了状態にする
     *
     * @return void
     */
    public function undone()
    {
        $this->isDone = 0;
    }

    /**
     * タスクIDを持っているか
     *
     * @return boolean
     */
    public function hasId(): bool
    {
        return !empty($this->id);
    }
}
