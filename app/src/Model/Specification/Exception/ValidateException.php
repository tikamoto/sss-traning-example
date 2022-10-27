<?php

namespace App\Model\Specification\Exception;

use App\Model\Entity\Entity;

/**
 * バリデーションエラー
 */
class ValidateException extends \DomainException
{
    /**
     * Entityを継承したクラス
     *
     * @var Entity
     */
    private Entity $entity;

    /**
     * エラー配列
     *
     * @var array
     */
    private array $errors;

    /**
     * Constructor
     *
     * @param Entity $entity
     * @param array $errors
     */
    public function __construct(Entity $entity, array $errors = [])
    {
        parent::__construct();
        $this->entity = $entity;
        $this->errors = $errors;
    }

    /**
     * エラーが発生しているか
     *
     * @return boolean
     */
    public function hasError(): bool
    {
        return !empty($this->errors);
    }

    /**
     * エラー取得
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * エンティティ取得
     *
     * @return Entity
     */
    public function getEntity(): Entity
    {
        return $this->entity;
    }
}
