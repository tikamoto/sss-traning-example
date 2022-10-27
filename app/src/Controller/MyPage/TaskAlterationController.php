<?php

namespace App\Controller\MyPage;

use App\Infra\Http\Request;
use App\Infra\Http\Response;
use App\Infra\Http\Exception\NotFoundException;
use App\Infra\Repository\TaskRepository;
use App\Model\Service\TaskService;
use App\Model\Specification\Exception\ValidateException;

/**
 * タスク編集画面コントローラ
 */
class TaskAlterationController extends MyPageController
{
    /**
     * @var TaskService
     */
    private TaskService $taskService;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->taskService = new TaskService(
            new TaskRepository()
        );
    }

    /**
     * タスク編集画面表示
     *
     * @param Request $request
     * @return Response
     * @throws NotFoundException
     */
    public function index(Request $request): Response
    {
        $task = $this->taskService->getTask(
            $this->authorizedUser->id,
            $request->get("taskId")
        );
        if (!$task) {
            throw new NotFoundException();
        }
        return $this->view("task-edit", [
            "task"  => $task
        ]);
    }

    /**
     * タスク編集
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        $this->verifyCsrfToken($request->post("token"));

        try {
            $this->taskService->updateTask(
                $this->authorizedUser->id,
                $request->post("task")
            );
        } catch (ValidateException $e) {
            return $this->view("task-edit", [
                "errors" => $e->getErrors(),
                "task"   => $e->getEntity()
            ]);
        }

        return $this->redirect("/task/create");
    }

    /**
     * タスク削除
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        $this->verifyCsrfToken($request->post("token"));

        $taskId = $request->post("taskId");
        $this->taskService->deleteTask($this->authorizedUser->id, $taskId);
        return $this->redirect("/task/create");
    }
}
