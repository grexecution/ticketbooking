<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Log;

class MediaHelper
{

    /**
     * @param Model       $model
     * @param string      $nameCollect
     * @param string|null $fileName
     */
    public static function handleMedia(Model $model, string $nameCollect, ? string $fileName = null) : void
    {
        if (! $fileName) {
            $model->clearMediaCollection($nameCollect);
            return;
        }

        if (! $model->$nameCollect) {
            static::attachMedia($model, $nameCollect, $fileName);
            return;
        }

        if ($model->$nameCollect->file_name !== $fileName) {
            static::deleteMedia($model, $nameCollect, $model->$nameCollect->file_name);
            static::attachMedia($model, $nameCollect, $fileName);
        }
    }

    /**
     * @param Model  $model
     * @param string     $nameCollect
     * @param array|null $fileNames
     */
    public static function handleMediaCollect(Model $model, string $nameCollect, ? array $fileNames = []) : void
    {
        if (empty($fileNames)) {
            $model->clearMediaCollection($nameCollect);
            return;
        }

        $existNames = collect($model->$nameCollect)->pluck('file_name');
        $inputNames = collect($fileNames);

        $toInsert = $inputNames->diff($existNames);
        $toDelete = $existNames->diff($inputNames);

        $toInsert->each(function (string $fileName) use ($model, $nameCollect) {
            static::attachMedia($model, $nameCollect, $fileName);
        });

        $toDelete->each(function (string $fileName) use ($model, $nameCollect) {
            static::deleteMedia($model, $nameCollect, $fileName);
        });
    }

    /**
     * @param Model  $model
     * @param string $field
     * @param string $name
     */
    private static function attachMedia(Model $model, string $field, string $name) : void
    {
        try {
            $model
                ->addMedia(storage_path('tmp/uploads/' . $name))
                ->toMediaCollection($field);

        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * @param Model  $model
     * @param string $field
     * @param string $fileName
     */
    private static function deleteMedia(Model $model, string $field, string $fileName) : void
    {
        try {
            $model
                ->getMedia($field)->filter(function (Media $media) use ($fileName) {
                    return $media->getAttribute('file_name') === $fileName;
                })->each(function (Media $media) {
                    $media->delete();
                });

        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }
    }

}
