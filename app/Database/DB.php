<?php

namespace AdventureTime\Database;

use Base;

class DB
{
    /**
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $base
     * @param string $charset
     * @return \PDO
     */
    public static function pdo(string $host, string $user, string $pass, string $base, string $charset = 'utf8'): \PDO
    {
        $data = [
            'host' => $host,
            'user' => $user,
            'pass' => $pass,
            'base' => $base,
            'charset' => $charset
        ];

        try {
            return Base::connect('mysql', $data);
        } catch (\PDOException $e) {
            die('Нет подключения к базе данных.');
        }
    }
}

