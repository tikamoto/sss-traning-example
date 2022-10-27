<?php

namespace App\Model\Service;

use App\Model\Entity\Task;
use App\Model\Collection\TaskCollection;
use App\Model\Repository\TaskRepositoryInterface;
use App\Model\Specification\Exception\ValidateException;
use App\Model\Specification\TaskSpec;

/**
 * タスクサービス
 */
class TaskService
{
    /**
     * Constructor
     *
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {
    }

    /**
     * ユーザのタスクを1件取得
     *
     * @param integer $userId
     * @param integer $taskId
     * @return Task
     */
    public function getTask(int $userId, int $taskId): Task
    {
        return $this->taskRepository->findOneById($taskId, $userId);
    }

    /**
     * ユーザのタスクを全て取得
     *
     * @param integer $userId
     * @return TaskCollection
     */
    public function getTasks(int $userId): TaskCollection
    {
        $tasks = $this->taskRepository->findAllByUserId($userId);
        $tasks->sort();
        return $tasks;
    }

    /**
     * タスクの作成
     *
     * @param integer $userId
     * @param array $data
     * @return Task
     * @throws ValidateException
     */
    public function createTask(int $userId, array $data): Task
    {
        $task = new Task(
            userId: $userId,
            expiredOn: $data["expiredOn"] ?? "",
            description: $data["description"] ?? "",
            isDone: 0
        );

        try {
            $spec = new TaskSpec();
            $spec->validate($task);
        } catch (ValidateException $e) {
            throw $e;
        }

        return $this->taskRepository->save($task);
    }

    /**
     * タスクの更新
     *
     * @param integer $userId
     * @param array $data
     * @return Task
     * @throws \DomainException|ValidateException
     */
    public function updateTask(int $userId, array $data): Task
    {

        $task = new Task(
            id: $data["id"] ?? null,
            userId: $userId,
            expiredOn: $data["expiredOn"] ?? "",
            description: $data["description"] ?? "",
            isDone: $data["isDone"] ?? 0
        );

        if (!$task->hasId()) {
            throw new \DomainException();
        }

        try {
            $spec = new TaskSpec();
            $spec->validate($task);
        } catch (ValidateException $e) {
            throw $e;
        }

        return $this->taskRepository->save($task);
    }

    /**
     * タスクの削除
     *
     * @param integer $userId
     * @param integer $taskId
     * @return void
     */
    public function deleteTask(int $userId, int $taskId)
    {
        $this->taskRepository->delete($userId, $taskId);
    }

    /**
     * タスクの状態を未完了⇒完了に変更
     *
     * @param integer $userId
     * @param integer $taskId
     * @return void
     */
    public function changeToDone(int $userId, int $taskId)
    {
        $task = $this->taskRepository->findOneById($taskId, $userId);
        if ($task) {
            $task->done();
            $this->taskRepository->save($task);
        }
    }

    /**
     * タスクの状態を完了⇒未完了に変更
     *
     * @param integer $userId
     * @param integer $taskId
     * @return void
     */
    public function changeToUnDone(int $userId, int $taskId)
    {
        $task = $this->taskRepository->findOneById($taskId, $userId);
        if ($task) {
            $task->undone();
            $this->taskRepository->save($task);
        }
    }
}
