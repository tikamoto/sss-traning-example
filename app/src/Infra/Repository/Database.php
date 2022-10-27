<?php

namespace App\Infra\Repository;

use App\Config;

/**
 * データベース操作クラス
 */
class Database
{
    /**
     * DBコネクション
     *
     * @var \PDO
     */
    private static \PDO $connection;


    /**
     * Constructor
     * 
     * @throws \PDOException
     */
    public function __construct()
    {
        if (empty(self::$connection)) {
            try {
                self::$connection = new \PDO(
                    "mysql:dbname=" . Config::get("DB_NAME") . ";host=" . Config::get("DB_HOST"),
                    Config::get("DB_USER"),
                    Config::get("DB_PASSWORD")
                );
            } catch (\PDOException $e) {
                throw $e;
            }
        }
    }

    /**
     * データを1件取得
     *
     * @param string $sql
     * @param array $values
     * @return array|false
     */
    public function fetch(string $sql, array $values): array|false
    {
        $stmt = $this->execute($sql, $values);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * データを全件取得
     *
     * @param string $sql
     * @param array $values
     * @return array
     */
    public function fetchAll(string $sql, array $values): array
    {
        $stmt = $this->execute($sql, $values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * SQL実行
     *
     * @param string $sql
     * @param array $values
     * @return \PDOStatement
     */
    public function execute(string $sql, array $values): \PDOStatement
    {
        $stmt = self::$connection->prepare($sql);
        foreach ($values as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    /**
     * 最後にINSERTしたauto_incrementの値を取得
     *
     * @return integer
     */
    public function getLastInsertId(): int
    {
        return self::$connection->lastInsertId();
    }

    /**
     * トランザクションの開始
     *
     * @return void
     */
    public function beginTransaction()
    {
        self::$connection->beginTransaction();
    }

    /**
     * コミット
     *
     * @return void
     */
    public function commit()
    {
        self::$connection->commit();
    }

    /**
     * ロールバック
     *
     * @return void
     */
    public function rollback()
    {
        self::$connection->rollBack();
    }
}
