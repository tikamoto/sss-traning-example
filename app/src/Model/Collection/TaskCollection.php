<?php

namespace App\Model\Collection;

use App\Model\Entity\Task;

/**
 * タスクコレクション
 */
class TaskCollection extends \ArrayObject
{
    /**
     * Constructor
     *
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        $this->checkType(...$array);
        parent::__construct($array);
    }

    /**
     * 並び替え
     *
     * @return void
     */
    public function sort()
    {
        $this->uasort(function (Task $a, Task $b): int {

            // NOTE:
            // $aと$bのタスクを比較し、
            // $aを$bよりも上位にしたければ-1を、
            // $aを$bよりも下位にしたければ1を返す

            $aTime = strtotime($a->expiredOn);
            $bTime = strtotime($b->expiredOn);

            //未完了と完了の並び順（未完了⇒完了）
            if ($a->isDone() != $b->isDone()) {
                return $a->isDone() && !$b->isDone() ? 1 : -1;
            }
            //期日が同じ場合の並び順（登録日の降順）
            if ($aTime == $bTime) {
                return strtotime($a->createdAt) < strtotime($b->createdAt) ? 1 : -1;
            }
            //未完了の中で期日が違う場合の並び順（期日の昇順）
            if (!$a->isDone() && !$b->isDone()) {
                return $aTime > $bTime ? 1 : -1;
            }
            //完了の中で期日が違う場合の並び順（期日の降順）
            if ($a->isDone() && $b->isDone()) {
                return $aTime < $bTime ? 1 : -1;
            }
            return 0;
        });
    }

    /**
     * ArrayObject::append
     *
     * @param mixed $value
     * @return void
     */
    public function append(mixed $value): void
    {
        $this->checkType($value);
        parent::append($value);
    }

    /**
     * ArrayObject::offsetSet
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        $this->checkType($value);
        parent::offsetSet($key, $value);
    }

    /**
     * 型チェック
     *
     * @param Task ...$value
     * @return void
     */
    private function checkType(Task ...$value)
    {
    }
}
