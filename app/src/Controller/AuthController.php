<?php

namespace App\Controller;

use App\Infra\Http\Request;
use App\Infra\Http\Response;
use App\Model\Entity\User;

/**
 * ログイン/ログアウト画面コントローラ
 */
class AuthController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ログイン画面表示
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->view("login", [
            "user" => new User()
        ]);
    }

    /**
     * ログイン処理
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        $this->verifyCsrfToken($request->post("token"));

        $data = $request->post("user");
        $user = new User(
            email: $data["email"] ?? "",
            password: $data["password"] ?? ""
        );

        $authenticatedUser = $this->authService->authenticate($user);
        if ($authenticatedUser) {
            $this->authService->authorize($authenticatedUser);
            return $this->redirect("/task/create");
        }

        return $this->view("login", [
            "user" => $user,
            "error" => "Email or Password is incorrect."
        ]);
    }

    /**
     * ログアウト処理
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        $this->authService->deauthorize();
        return $this->redirect("/login");
    }
}
