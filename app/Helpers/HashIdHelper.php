<?php

namespace App\Helpers;

class HashIdHelper
{

    public static function encodeId($id) : string
    {
        return rtrim(strtr(base64_encode($id), '+/', '-_'), '=');
    }

    public static function decodeId($hash) : string
    {
        return base64_decode(strtr($hash, '-_', '+/'));
    }

}
