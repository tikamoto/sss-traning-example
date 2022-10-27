<?php

namespace App\Infra\Repository;

use App\Model\Entity\Task;
use App\Model\Collection\TaskCollection;
use App\Model\Repository\TaskRepositoryInterface;

/**
 * タスクリポジトリ
 */
class TaskRepository implements TaskRepositoryInterface
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
     * タスクIDとユーザIDからタスクを1件取得
     *
     * @param integer $taskId
     * @param integer $userId
     * @return Task|null
     */
    public function findOneById(int $taskId, int $userId): ?Task
    {
        $data = $this->db->fetch(
            "SELECT * FROM tasks WHERE user_id = :user_id AND id = :id",
            [
                "id" => $taskId,
                "user_id" => $userId
            ]
        );
        return $data ? new Task(
            id: $data["id"],
            userId: $data["user_id"],
            expiredOn: $data["expired_on"],
            description: $data["description"],
            isDone: $data["is_done"],
            createdAt: $data["created_at"]
        ) : null;
    }

    /**
     * ユーザIDに紐づくタスクを全て取得
     *
     * @param integer $userId
     * @return TaskCollection
     */
    public function findAllByUserId(int $userId): TaskCollection
    {
        $datas = $this->db->fetchAll(
            "SELECT * FROM tasks WHERE user_id = :user_id",
            [
                "user_id" => $userId
            ]
        );
        $tasks = new TaskCollection();
        foreach ($datas as $data) {
            $tasks[] = new Task(
                id: $data["id"],
                userId: $data["user_id"],
                expiredOn: $data["expired_on"],
                description: $data["description"],
                isDone: $data["is_done"],
                createdAt: $data["created_at"]
            );
        }
        return $tasks;
    }

    /**
     * タスクの保存
     *
     * @param Task $task
     * @return Task
     */
    public function save(Task $task): Task
    {
        if ($task->hasId()) {
            $taskId = $this->update($task);
        } else {
            $taskId = $this->create($task);
        }
        return $this->findOneById($taskId, $task->userId);
    }

    /**
     * タスクの削除
     *
     * @param integer $userId
     * @param integer $taskId
     * @return void
     */
    public function delete(int $userId, int $taskId)
    {
        $this->db->execute(
            "DELETE FROM tasks WHERE user_id = :user_id AND id = :id",
            [
                "id" => $taskId,
                "user_id" => $userId
            ]
        );
    }

    /**
     * タスクの全削除
     *
     * @param integer $userId
     * @return void
     */
    public function deleteAll(int $userId)
    {
        $this->db->execute(
            "DELETE FROM tasks WHERE user_id = :user_id",
            [
                "user_id" => $userId
            ]
        );
    }

    /**
     * タスクの作成
     *
     * @param Task $task
     * @return integer タスクID
     */
    private function create(Task $task): int
    {
        $this->db->execute(
            "INSERT INTO tasks (user_id, expired_on, description, is_done) VALUES (:user_id, :expired_on, :description, :is_done)",
            [
                "user_id" => $task->userId,
                "expired_on" => $task->expiredOn,
                "description" => $task->description,
                "is_done" => $task->isDone,
            ]
        );
        return $this->db->getLastInsertId();
    }

    /**
     * タスクの更新
     *
     * @param Task $task
     * @return integer タスクID
     */
    private function update(Task $task): int
    {
        $this->db->execute(
            "UPDATE tasks SET user_id = :user_id, expired_on = :expired_on, description = :description, is_done = :is_done WHERE id = :id AND user_id = :user_id",
            [
                "id" => $task->id,
                "user_id" => $task->userId,
                "expired_on" => $task->expiredOn,
                "description" => $task->description,
                "is_done" => $task->isDone
            ]
        );
        return $task->id;
    }
}
