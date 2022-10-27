<?php

namespace App\Controller\MyPage;

use App\Infra\Http\Request;
use App\Infra\Http\Response;
use App\Infra\Repository\TaskRepository;
use App\Infra\Repository\UserRepository;
use App\Model\Service\UserService;
use App\Model\Specification\Exception\ValidateException;

/**
 * ユーザ編集画面コントローラ
 */
class UserAlterationController extends MyPageController
{
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService(
            new UserRepository(),
            new TaskRepository()
        );
    }

    /**
     * ユーザ編集画面表示
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->view("account", [
            "user"  => $this->authorizedUser
        ]);
    }

    /**
     * ユーザ編集
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        $this->verifyCsrfToken($request->post("token"));

        try {
            $this->userService->updateUser(
                $this->authorizedUser->id,
                $request->post("user")
            );
        } catch (ValidateException $e) {
            return $this->view("account", [
                "errors" => $e->getErrors(),
                "user"   => $e->getEntity()
            ]);
        }

        return $this->redirect("/user/update");
    }

    /**
     * ユーザ削除
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        $this->verifyCsrfToken($request->post("token"));

        $this->userService->deleteUser($this->authorizedUser->id);
        $this->authService->deauthorize();
        return $this->redirect("/login");
    }
}
