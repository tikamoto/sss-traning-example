<?php

namespace App\Model\Entity;

/**
 * エンティティ基底クラス
 */
abstract class Entity
{
    /**
     * ゲッタ
     *
     * @param string $field
     * @return mixed
     * @throws \DomainException
     */
    public function __get(string $field): mixed
    {
        if (!property_exists($this, $field)) {
            throw new \DomainException();
        }
        $value = $this->{$field};
        return $value;
    }
}
