<?php

namespace App\Helpers;

class LogHelper
{

    /**
     * @param $model
     * @param string $text
     */
    public static function logMediaUpdate($model, string $text) : void
    {
        $dir = storage_path('media/' . date('Y-m-d') . '/' . $model->id . '/' . date('H') . '-00');
        $path = $dir . '/' . time() .'.txt';

        FileSystemHelper::checkExistsFolder($dir);

        file_put_contents($path, "\n". $text, FILE_APPEND);
    }

}
