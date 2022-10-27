<?php

namespace App\Model\Specification\Assertion;

/**
 * カスタムバリデーション
 */
class Custom implements AssertionInterface
{
    /**
     * Constructor
     *
     * @param \Closure $callback 値チェック用のコールバック関数
     * @param string $message エラーメッセージ
     */
    public function __construct(
        private \Closure $callback,
        private string $message
    ) {
    }

    /**
     * 入力値の妥当性チェック
     *
     * @param string $value
     * @return boolean
     */
    public function isValid(string $value): bool
    {
        return call_user_func($this->callback, $value);
    }

    /**
     * エラーメッセージ取得
     *
     * @param string $label
     * @return string
     */
    public function getMessage(string $label): string
    {
        return sprintf($this->message, $label);
    }
}
