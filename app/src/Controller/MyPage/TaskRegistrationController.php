<?php

namespace App\Controller\MyPage;

use App\Infra\Http\Request;
use App\Infra\Http\Response;
use App\Infra\Repository\TaskRepository;
use App\Model\Service\TaskService;
use App\Model\Specification\Exception\ValidateException;
use App\Model\Entity\Task;

/**
 * タスク作成・一覧画面コントローラ
 */
class TaskRegistrationController extends MyPageController
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
     * タスク作成・一覧画面表示
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->view("tasks", [
            "task" => new Task(),
            "tasks" => $this->taskService->getTasks($this->authorizedUser->id)
        ]);
    }

    /**
     * タスク作成
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $this->verifyCsrfToken($request->post("token"));

        try {
            $this->taskService->createTask(
                $this->authorizedUser->id,
                $request->post("task")
            );
        } catch (ValidateException $e) {
            return $this->view("tasks", [
                "errors" => $e->getErrors(),
                "task"   => $e->getEntity(),
                "tasks"  => $this->taskService->getTasks($this->authorizedUser->id)
            ]);
        }

        return $this->redirect("/task/create");
    }

    /**
     * タスクの完了状態切替
     *
     * @param Request $request
     * @return Response
     */
    public function complete(Request $request): Response
    {
        $this->verifyCsrfToken($request->post("token"));

        $taskId = $request->post("taskId");

        if ($request->post("done")) {
            $this->taskService->changeToDone($this->authorizedUser->id, $taskId);
        } elseif ($request->post("undone")) {
            $this->taskService->changeToUnDone($this->authorizedUser->id, $taskId);
        }

        return $this->redirect("/task/create");
    }
}
