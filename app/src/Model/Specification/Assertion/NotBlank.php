<?php

namespace App\Model\Specification\Assertion;

/**
 * 必須（空欄ではない）チェック
 */
class NotBlank implements AssertionInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * 入力値の妥当性チェック
     *
     * @param string $value
     * @return boolean
     */
    public function isValid(string $value): bool
    {
        return $value !== "";
    }

    /**
     * エラーメッセージ取得
     *
     * @param string $label
     * @return string
     */
    public function getMessage(string $label): string
    {
        return sprintf("%s must be filled.", $label);
    }
}
