<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\MediaUploadRequest;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{

    /**
     * @param MediaUploadRequest $request
     * @param FileService       $service
     *
     * @return JsonResponse
     */
    public function uploadFile(MediaUploadRequest $request, FileService $service) : JsonResponse
    {
        [$name, $originName] = $service->createFile($request);

        return response()->json([
            'name' => $name,
            'original_name' => $originName,
        ]);
    }

}
