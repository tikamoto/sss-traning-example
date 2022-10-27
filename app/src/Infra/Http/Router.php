<?php

namespace App\Infra\Http;

use App\Infra\Http\Request;
use App\Infra\Http\Exception\NotFoundException;
use App\Infra\Http\Exception\HttpException;
use App\Infra\Http\Exception\InternalServerErrorException;

/**
 * ルータ
 */
class Router
{
    /**
     * GETリクエスト時のルート
     *
     * @var array
     */
    private array $gets;

    /**
     * POSTリクエスト時のルート
     *
     * @var array
     */
    private array $posts;

    /**
     * エラー発生時のルート
     *
     * @var array
     */
    private array $errors;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gets   = [];
        $this->posts  = [];
        $this->errors = [];
    }

    /**
     * GETリクエストのルーティング定義
     *
     * @param string $path URLパス
     * @param string $className コントローラクラス名
     * @param string $methodName コントローラメソッド名
     * @return Router
     */
    public function get(string $path, string $className, string $methodName): Router
    {
        $this->gets[$path] = ['class' => $className, 'method' => $methodName];
        return $this;
    }

    /**
     * POSTリクエストのルーティング定義
     *
     * @param string $path URLパス
     * @param string $className コントローラクラス名
     * @param string $methodName コントローラメソッド名
     * @return Router
     */
    public function post(string $path, string $className, string $methodName): Router
    {
        $this->posts[$path] = ['class' => $className, 'method' => $methodName];
        return $this;
    }

    /**
     * エラー時のルーティング定義
     *
     * @param integer $statusCode ステータスコード
     * @param string $className コントローラクラス名
     * @param string $methodName コントローラメソッド名
     * @return Router
     */
    public function error(int $statusCode, string $className, string $methodName): Router
    {
        $this->errors[$statusCode] = ['class' => $className, 'method' => $methodName];
        return $this;
    }

    /**
     * レスポンス返却
     *
     * @return void
     */
    public function respond()
    {
        $httpError = null;
        $request = new Request();

        try {

            //リクエストメソッドのチェック
            if (!$request->isGet() && !$request->isPost()) {
                throw new NotFoundException();
            }

            //リクエストURLのチェック
            $route = $request->isGet()
                ? $this->gets[$request->path()] ?? null
                : $this->posts[$request->path()] ?? null;
            if (!$route) {
                throw new NotFoundException();
            }

            //コントローラの実行
            $response = (new $route["class"]())->{$route["method"]}($request);

        } catch (HttpException $e) {
            $httpError = $e;
        } catch (\Exception $e) {
            $httpError = new InternalServerErrorException();
        }

        //コントローラから例外がスローされた場合はルーティングで定義されたエラー表示用のコントローラを再実行
        if ($httpError) {
            $response = $httpError->getResponse();
            $route = $this->errors[$response->statusCode] ?? null;
            if ($route) {
                try {
                    $response = (new $route["class"]())->{$route["method"]}($request);
                } catch (\Exception $e) {
                }
            }
        }

        //レスポンス返却
        http_response_code($response->statusCode);
        if ($response->statusCode == 301 || $response->statusCode == 302) {
            header("Location: " . $response->content);
            exit;
        } else {
            echo $response->content;
        }
        exit;
    }
}
