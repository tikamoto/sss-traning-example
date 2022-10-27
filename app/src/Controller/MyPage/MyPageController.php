<?php

namespace App\Controller\MyPage;

use App\Infra\Http\Response;
use App\Infra\Http\Exception\UnauthorizedException;
use App\Controller\Controller;
use App\Model\Entity\User;

/**
 * マイページ基底クラス
 */
abstract class MyPageController extends Controller
{
    /**
     * 認可（ログイン）済みユーザー
     *
     * @var User|null
     */
    protected ?User $authorizedUser;

    /**
     * Constructor
     * 
     * @throws UnauthorizedException
     */
    public function __construct()
    {
        parent::__construct();
        $this->authorizedUser = $this->authService->getAuthorizedUser();
        if (!$this->authorizedUser) {
            $response = new Response(302, "/login");
            throw new UnauthorizedException($response);
        }
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
        $vars["authorizedUser"] = $this->authorizedUser;
        return parent::view($template, $vars);
    }
}
