<?php

namespace App\Model\Specification\Assertion;

/**
 * アサーションインターフェース
 */
interface AssertionInterface
{
    /**
     * 入力値の妥当性チェック
     *
     * @param string $value
     * @return boolean
     */
    public function isValid(string $value): bool;

    /**
     * エラーメッセージ取得
     *
     * @param string $label
     * @return string
     */
    public function getMessage(string $label): string;
}
