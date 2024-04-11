<?php

namespace App\Services;

use App\Helpers\FileSystemHelper;
use App\Http\Requests\Media\MediaUploadRequest;
use Illuminate\Http\Request;

class FileService
{

    /**
     * @param MediaUploadRequest|Request $request
     * @param string $fileName
     * @param string $path
     * @return array
     */
    public function createFile(MediaUploadRequest|Request $request, string $fileName = 'file', string $path = 'tmp/uploads') : array
    {
        $file = $request->file($fileName);
        $name = uniqid() . '_' . $this->clearFileName($file);
        $dir = storage_path($path);
        FileSystemHelper::checkExistsFolder($dir);
        $file->move($dir, $name);

        return [$name, $file->getClientOriginalName(), $dir];
    }

    /**
     * @param $file
     * @return string
     */
    private function clearFileName($file) : string
    {
        $name = str_replace($file->getClientOriginalExtension(), '', $file->getClientOriginalName());
        $name = preg_replace('/\./', '-', $name);
        $name = rtrim($name, '-');

        return sprintf("%s.%s", $name, $file->getClientOriginalExtension());
    }

}
