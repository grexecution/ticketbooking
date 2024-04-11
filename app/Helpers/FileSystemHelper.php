<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class FileSystemHelper
{

    /**
     * @param string $path
     */
    public static function checkExistsFolder(string $path) : void
    {
        try {
            if (! file_exists($path)) {
                mkdir($path, 0755, true);
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
