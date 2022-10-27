<?php

namespace App\Infra\Repository;

/**
 * セッション操作クラス
 */
class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } 
    }

    /**
     * セッションの値を取得
     *
     * @param string $key
     * @param mixed $default キーが存在しない場合のデフォルト値
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * セッションに値をセット
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * セッションの値を削除
     *
     * @param string $key
     * @return void
     */
    public function unset(string $key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * セッションの破棄
     *
     * @return void
     */
    public function destroy()
    {
        $_SESSION = [];
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            "",
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
        session_destroy();
    }
}
