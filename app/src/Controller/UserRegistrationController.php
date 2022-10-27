<?php

namespace App\Controller;

use App\Infra\Http\Request;
use App\Infra\Http\Response;
use App\Infra\Repository\TaskRepository;
use App\Infra\Repository\UserRepository;
use App\Model\Service\UserService;
use App\Model\Specification\Exception\ValidateException;
use App\Model\Entity\User;

/**
 * ユーザ作成画面コントローラ
 */
class UserRegistrationController extends Controller
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
     * ユーザ作成画面表示
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->view("sign-up", [
            "user" => new User()
        ]);
    }

    /**
     * ユーザ作成
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $this->verifyCsrfToken($request->post("token"));
        
        try {
            $user = $this->userService->createUser(
                $request->post("user")
            );
        } catch (ValidateException $e) {
            return $this->view("sign-up", [
                "errors" => $e->getErrors(),
                "user"   => $e->getEntity()
            ]);
        }

        $this->authService->authorize($user);

        return $this->redirect("/task/create");
    }
}
