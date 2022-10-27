<?php

namespace App\Model\Repository;

use App\Model\Entity\Task;
use App\Model\Collection\TaskCollection;

/**
 * タスクリポジトリインターフェース
 */
interface TaskRepositoryInterface
{
    /**
     * タスクIDとユーザIDからタスクを1件取得
     *
     * @param integer $taskId
     * @param integer $userId
     * @return Task|null
     */
    public function findOneById(int $taskId, int $userId): ?Task;

    /**
     * ユーザIDに紐づくタスクを全て取得
     *
     * @param integer $userId
     * @return TaskCollection
     */
    public function findAllByUserId(int $userId): TaskCollection;

    /**
     * タスクの保存
     *
     * @param Task $task
     * @return Task
     */
    public function save(Task $task): Task;

    /**
     * タスクの削除
     *
     * @param integer $userId
     * @param integer $taskId
     * @return void
     */
    public function delete(int $userId, int $taskId);

    /**
     * タスクの全削除
     *
     * @param integer $userId
     * @return void
     */
    public function deleteAll(int $userId);
}
