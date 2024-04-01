<?php

namespace App\Helpers;

use JetBrains\PhpStorm\NoReturn;

class SqlHelper
{

    /**
     * @param $query
     * @return string
     */
    public static function getSql($query) : string
    {
        $bindings = $query->getBindings();

        return preg_replace_callback('/\?/', function ($match) use (&$bindings, $query) {
            return $query
                ->getConnection()
                ->getPdo()
                ->quote(array_shift($bindings));

        }, $query->toSql());
    }

    #[NoReturn]
    public static function ddSql($query) : void
    {
        dd(self::getSql($query));
    }

}
