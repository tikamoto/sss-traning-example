<?php

namespace App\Controller;

use App\Config;
use App\Infra\Http\Exception\ForbiddenException;
use App\Infra\Http\Response;
use App\Infra\Repository\ActivationRepository;
use App\Infra\Repository\UserRepository;
use App\Model\Service\AuthService;

/**
 * コントローラ基底クラス
 */
abstract class Controller
{
    /**
     * @var AuthService
     */
    protected AuthService $authService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authService = new AuthService(
            new ActivationRepository(),
            new UserRepository()
        );
    }

    /**
     * viewの生成
     *
     * @param string $template テンプレートパス
     * @param array $vars テンプレート内変数
     * @param integer $statusCode ステータスコード
     * @return Response
     */
    protected function view(string $template, array $vars = [], $statusCode = 200): Response
    {
        $vars["token"] = $this->authService->generateOnetimeToken();
        $vars["h"] = function ($value) {
            return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
        };
        extract($vars);
        ob_start();
        include(Config::get("APP_ROOT_DIR") . "/View/" . $template . ".php");
        $body = ob_get_contents();
        ob_end_clean();
        return new Response($statusCode, $body);
    }

    /**
     * リダイレクト
     *
     * @param string $path リダイレクト先URL
     * @return Response
     */
    protected function redirect(string $path): Response
    {
        return new Response(301, $path);
    }

    /**
     * CSRFトークンの検証
     *
     * @param string $token
     * @return boolean
     * @throws ForbiddenException
     */
    protected function verifyCsrfToken(string $token): bool
    {
        if ($this->authService->verifyOnetimeToken($token) == false) {
            throw new ForbiddenException();
        }
        return true;
    }
}
